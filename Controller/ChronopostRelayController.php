<?php


namespace Chronopost\Controller;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Chronopost\Model\ChronopostOrderQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Base\OrderAddressQuery;
use Thelia\Model\Order;

class ChronopostRelayController extends BaseAdminController
{
    public function findByAddress($orderWeight, $address, $zipCode, $city, $countryCode)
    {
        $config = ChronopostConst::getConfig();

        $datetime = new \DateTime('tomorrow');
        $tomorrow = $datetime->format('d/m/Y');

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
            "maxPointChronopost" => '15',
            "maxDistanceSearch" => '10',
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
}