<?php


namespace Chronopost\EventListeners;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Delivery\PickupLocationEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\PickupLocation;
use Thelia\Model\PickupLocationAddress;

class APIListener implements EventSubscriberInterface
{
    /**
     * Calls the Chronopost API and returns a response containing the informations of the relay points found
     *
     * @param PickupLocationEvent $pickupLocationEvent
     * @return mixed
     * @throws \SoapFault
     */
    protected function callWebService(PickupLocationEvent $pickupLocationEvent)
    {
        $config = ChronopostConst::getConfig();

        $datetime = new \DateTime('tomorrow');
        $tomorrow = $datetime->format('d/m/Y');

        $zipCode = $pickupLocationEvent->getZipCode();
        $city = $pickupLocationEvent->getCity();
        $address = $pickupLocationEvent->getAddress();
        $orderWeight = $pickupLocationEvent->getOrderWeight();
        $radius = (int)round(((float)$pickupLocationEvent->getRadius() / 1000));
        $maxRelays = $pickupLocationEvent->getMaxRelays() > 25 ? 25 : $pickupLocationEvent->getMaxRelays();
        $countryCode = '';

        if ($country = $pickupLocationEvent->getCountry()) {
            $countryCode = $country->getIsoalpha2();
        }

        /** START */

        /** SHIPPER INFORMATIONS */
        $APIData = [
            "accountNumber" => $config[ChronopostConst::CHRONOPOST_CODE_CLIENT],
            "password" => $config[ChronopostConst::CHRONOPOST_PASSWORD],
            "adress" => $address,
            "zipCode" => $zipCode,
            "city" => $city,
            "countryCode" => $countryCode,
            "type" => 'T',
            "productCode" => '58',
            "service" => 'T',
            "weight" => $orderWeight,
            "shippingDate" => $tomorrow,
            "maxPointChronopost" => $maxRelays,
            "maxDistanceSearch" => $radius,
            "holidayTolerant" => '1',
            "language" => 'FR',
            "version" => '2.0',
        ];

        /** Send informations to the Chronopost API */
        $soapClient = new \SoapClient(ChronopostConst::CHRONOPOST_RELAY_SEARCH_SERVICE_WSDL, array("trace" => 1, "exception" => 1));
        $response = $soapClient->__soapCall('recherchePointChronopostInterParService', [$APIData]);

        if (0 != $response->return->errorCode) {
            throw new \Exception($response->return->errorMessage);
        }

        return $response->return->listePointRelais;
    }

    /**
     * Creates and returns a new location address
     *
     * @param $response
     * @return PickupLocationAddress
     */
    protected function createPickupLocationAddressFromResponse($response)
    {
        /** We create the new location address */
        $pickupLocationAddress = new PickupLocationAddress();

        /** We set the differents properties of the location address */
        $pickupLocationAddress
            ->setId($response->identifiant)
            ->setTitle($response->nom)
            ->setAddress1($response->adresse1)
            ->setAddress2($response->adresse2)
            ->setAddress3($response->adresse3)
            ->setCity($response->localite)
            ->setZipCode($response->codePostal)
            ->setPhoneNumber('')
            ->setCellphoneNumber('')
            ->setCompany('')
            ->setCountryCode($response->codePays)
            ->setFirstName('')
            ->setLastName('')
            ->setIsDefault(0)
            ->setLabel('')
            ->setAdditionalData([])
        ;

        return $pickupLocationAddress;
    }

    /**
     * Creates then returns a location from a response of the WebService
     *
     * @param $response
     * @return PickupLocation
     * @throws \Exception
     */
    protected function createPickupLocationFromResponse($response)
    {
        /** We create the new location */
        $pickupLocation = new PickupLocation();

        /** We set the differents properties of the location */
        $pickupLocation
            ->setId($response->identifiant)
            ->setTitle($response->nom)
            ->setAddress($this->createPickupLocationAddressFromResponse($response))
            ->setLatitude($response->coordGeolocalisationLatitude)
            ->setLongitude($response->coordGeolocalisationLongitude)
            ->setModuleId(Chronopost::getModuleId())
        ;


        /** We set the opening hours separately since we got them as an array */
        foreach ($response->listeHoraireOuverture as $horaire) {
            $pickupLocation->setOpeningHours(($horaire->jour - 1), $horaire->horairesAsString);
        }

        return $pickupLocation;
    }

    /**
     * Get the list of locations (relay points)
     *
     * @param PickupLocationEvent $pickupLocationEvent
     * @throws \Exception
     */
    public function get(PickupLocationEvent $pickupLocationEvent)
    {
        if (null !== $moduleIds = $pickupLocationEvent->getModuleIds()) {
            if (!in_array(Chronopost::getModuleId(), $moduleIds)) {
                return ;
            }
        }

        /** The @var array $responses from the Webservice that calls the module API */
        $responses = $this->callWebService($pickupLocationEvent);

        foreach ($responses as $response) {
            /** For each response, we append a new location to the list */
            $pickupLocationEvent->appendLocation($this->createPickupLocationFromResponse($response));
        }
    }

    public static function getSubscribedEvents()
    {
        $listenedEvents = [];

        /** Check for old versions of Thelia where the events used by the API didn't exists */
        if (class_exists(PickupLocation::class)) {
            $listenedEvents[TheliaEvents::MODULE_DELIVERY_GET_PICKUP_LOCATIONS] = array("get", 130);
        }

        return $listenedEvents;
    }
}