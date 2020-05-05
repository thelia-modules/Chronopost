<?php

namespace Chronopost\EventListeners;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Chronopost\Model\ChronopostAddress;
use Chronopost\Model\ChronopostAddressQuery;
use Chronopost\Model\ChronopostOrder;
use Chronopost\Model\ChronopostOrderQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Log\Tlog;
use Thelia\Model\AddressQuery;
use Thelia\Model\Base\OrderAddressQuery;
use Thelia\Model\CountryQuery;
use Thelia\Model\Customer;
use Thelia\Model\Order;
use Thelia\Model\OrderAddress;
use Thelia\Model\OrderQuery;


class SetDeliveryType implements EventSubscriberInterface
{
    /** @var Request */
    protected $request;

    /**
     * SetDeliveryType constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function checkModule($id)
    {
        return $id == Chronopost::getModuleId();
    }

    /**
     * @param OrderEvent $orderEvent
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function saveChronopostOrder(OrderEvent $orderEvent)
    {
        if ($this->checkModule($orderEvent->getOrder()->getDeliveryModuleId())) {

            $request = $this->getRequest();
            $chronopostOrder = new ChronopostOrder();

            $orderId = $orderEvent->getOrder()->getId();

            if ($request->getSession()->get('ChronopostDeliveryFresh13') == 1) {
                $chronopostOrder
                    ->setDeliveryType("Fresh13")
                    ->setDeliveryCode("2R");
            } elseif ($request->getSession()->get('ChronopostDeliveryChrono13') == 1) {
                $chronopostOrder
                    ->setDeliveryType("Chrono13")
                    ->setDeliveryCode("01");
            } elseif ($request->getSession()->get('ChronopostDeliveryChrono18') == 1) {
                $chronopostOrder
                    ->setDeliveryType("Chrono18")
                    ->setDeliveryCode("16");
            } elseif ($request->getSession()->get('ChronopostDeliveryChrono13Bal') == 1) {
                $chronopostOrder
                    ->setDeliveryType("Chrono13Bal")
                    ->setDeliveryCode("56");
            } elseif ($request->getSession()->get('ChronopostDeliveryChronoClassic') == 1) {
                $chronopostOrder
                    ->setDeliveryType("ChronoClassic")
                    ->setDeliveryCode("44");
            } elseif ($request->getSession()->get('ChronopostDeliveryChronoExpress') == 1) {
                $chronopostOrder
                    ->setDeliveryType("ChronoExpress")
                    ->setDeliveryCode("17");
            }
            /** @TODO Add other delivery types */

            $chronopostOrder
                ->setOrderId($orderId)
                ->setLabelDirectory(Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_LABEL_DIR))
                ->save();
        }
    }

    /**
     * @param OrderEvent $orderEvent
     * @return null
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setChronopostDeliveryType(OrderEvent $orderEvent)
    {
        if ($this->checkModule($orderEvent->getDeliveryModule())) {
            $request = $this->getRequest();

            /** @TODO Add other delivery types */
            $isFresh13Enabled = $request->get('chronopost-fresh13');
            $isChrono13Enabled = $request->get('chronopost-chrono13');
            $isChrono18Enabled = $request->get('chronopost-chrono18');
            $isChrono13BalEnabled = $request->get('chronopost-chrono13bal');
            $isChronoClassicEnabled = $request->get('chronopost-chronoclassic');
            $isChronoExpressEnabled = $request->get('chronopost-chronoexpress');

            $request->getSession()->set('ChronopostAddressId', 0);
            $request->getSession()->set('ChronopostDeliveryFresh13', 0);
            $request->getSession()->set('ChronopostDeliveryChrono13', 0);
            $request->getSession()->set('ChronopostDeliveryChrono18', 0);
            $request->getSession()->set('ChronopostDeliveryChrono13Bal', 0);
            $request->getSession()->set('ChronopostDeliveryChronoClassic', 0);
            $request->getSession()->set('ChronopostDeliveryChronoExpress', 0);

            $request->getSession()->set('ChronopostAddressId', $orderEvent->getDeliveryAddress());

            if ($isFresh13Enabled) {
                $request->getSession()->set('ChronopostDeliveryFresh13', 1);
            } elseif ($isChrono13Enabled) {
                $request->getSession()->set('ChronopostDeliveryChrono13', 1);
            } elseif ($isChrono18Enabled) {
                $request->getSession()->set('ChronopostDeliveryChrono18', 1);
            } elseif ($isChrono13BalEnabled) {
                $request->getSession()->set('ChronopostDeliveryChrono13Bal', 1);
            } elseif ($isChronoClassicEnabled) {
                $request->getSession()->set('ChronopostDeliveryChronoClassic', 1);
            } elseif ($isChronoExpressEnabled) {
                $request->getSession()->set('ChronopostDeliveryChronoExpress', 1);
            } else {
                return;
            }
            /** @TODO END */
        }
        return;
    }

    /**
     * @param $countryId
     * @return string
     */
    private function getCountryIso($countryId)
    {
        return CountryQuery::create()->findOneById($countryId)->getIsoalpha2();
    }

    /**
     * @param OrderAddress $address
     * @return string
     */
    private function getContactName(OrderAddress $address)
    {
        $contactName = $address->getFirstname() . " " . $address->getLastname();
        return $contactName;
    }

    /**
     * @param Customer $customer
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    private function getChronopostCivility(Customer $customer)
    {
        $civ = $customer->getCustomerTitle()->getId();

        switch ($civ) {
            case 1:
                return 'M';
                break;
            case 2:
                return 'E';
                break;
            case 3:
                return 'L';
                break;
        }
        return 'M';
    }

    /**
     * Write the data to send to the Chronopost API as an array
     *
     * @param Order $order
     * @return mixed
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function writeAPIData(Order $order, $weight = null, $idBox = 1, $skybillRank = 1)
    {
        $config = ChronopostConst::getConfig();
        $customer = $order->getCustomer();

        $customer_invoice_address = OrderAddressQuery::create()->findPk($order->getInvoiceOrderAddressId());
        $customer_delivery_address = OrderAddressQuery::create()->findPk($order->getDeliveryOrderAddressId());

        $phone = $customer_delivery_address->getCellphone();

        if (null == $phone) {
            $phone = $customer_delivery_address->getPhone();
        }

        if (null === $weight) {
            //$weight = $this->pickingService->getOrderWeight($order->getId());
            $weight = 0;
        }

        $chronopostProductCode = ChronopostOrderQuery::create()->filterByOrderId($order->getId())->findOne()->getDeliveryCode();

        $name2 = "";
        if ($customer_delivery_address->getCompany()) {
            $name2 = self::getContactName($customer_delivery_address);
        }
        $name3 = "";
        if ($customer_invoice_address->getCompany()) {
            $name3 = self::getContactName($customer_invoice_address);
        }

        /** START */

        /** HEADER */
        if ($chronopostProductCode == '44') {
            $APIData["headerValue"] = [
                "idEmit" => "CHRFR",
                "accountNumber" => (int)$config[ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS],
                "subAccount" => "",
            ];
        } else {
            $APIData["headerValue"] = [
                "idEmit" => "CHRFR",
                "accountNumber" => (int)$config[ChronopostConst::CHRONOPOST_CODE_CLIENT],
                "subAccount" => "",
            ];
        }

        /** SHIPPER INFORMATIONS */
        $APIData["shipperValue"] = [
            "shipperCivility" => $config[ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY],
            "shipperName" => $config[ChronopostConst::CHRONOPOST_SHIPPER_NAME1],
            "shipperName2" => $config[ChronopostConst::CHRONOPOST_SHIPPER_NAME2],
            "shipperAdress1" => $config[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1],
            "shipperAdress2" => $config[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2],
            "shipperZipCode" => $config[ChronopostConst::CHRONOPOST_SHIPPER_ZIP],
            "shipperCity" => $config[ChronopostConst::CHRONOPOST_SHIPPER_CITY],
            "shipperCountry" => $config[ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY],
            "shipperContactName" => $config[ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME],
            "shipperEmail" => $config[ChronopostConst::CHRONOPOST_SHIPPER_MAIL],
            "shipperPhone" => $config[ChronopostConst::CHRONOPOST_SHIPPER_PHONE],
            "shipperMobilePhone" => $config[ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE],
            "shipperPreAlert" => 0, // todo ?
        ];

        /** CUSTOMER INVOICE INFORMATIONS */
        $APIData["customerValue"] = [
            "customerCivility" => self::getChronopostCivility($customer),
            "customerName" => $customer_invoice_address->getCompany(),
            "customerName2" => $name3,
            "customerAdress1" => $customer_invoice_address->getAddress1(),
            "customerAdress2" => $customer_invoice_address->getAddress2(),
            "customerZipCode" => $customer_invoice_address->getZipcode(),
            "customerCity" => $customer_invoice_address->getCity(),
            "customerCountry" => self::getCountryIso($customer_invoice_address->getCountryId()),
            "customerContactName" => self::getContactName($customer_invoice_address),
            "customerEmail" => $customer->getEmail(),
            "customerPhone" => $customer_invoice_address->getPhone(),
            "customerMobilePhone" => $customer_invoice_address->getCellphone(),
            "customerPreAlert" => 0,
            "printAsSender" => $config[ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS],
        ];

        /** CUSTOMER DELIVERY INFORMATIONS */
        $APIData["recipientValue"] = [
            "recipientName" => $customer_delivery_address->getCompany(),
            "recipientName2" => $name2,
            "recipientAdress1" => $customer_delivery_address->getAddress1(),
            "recipientAdress2" => $customer_delivery_address->getAddress2(),
            "recipientZipCode" => $customer_delivery_address->getZipcode(),
            "recipientCity" => $customer_delivery_address->getCity(),
            "recipientCountry" => self::getCountryIso($customer_delivery_address->getCountryId()),
            "recipientContactName" => self::getContactName($customer_delivery_address),
            "recipientEmail" => $customer->getEmail(),
            "recipientPhone" => $phone,
            "recipientMobilePhone" => $customer_delivery_address->getCellphone(),
            "recipientPreAlert" => 0,
        ];

        /** RefValue */
        $APIData["refValue"] = [
            "shipperRef" => $config[ChronopostConst::CHRONOPOST_SHIPPER_NAME1],
            "recipientRef" => $customer->getId(),
        ];

        /** SKYBILL  (LABEL INFORMATIONS) */
        $APIData["skybillValue"] = [
            "bulkNumber" => $idBox,
            "skybillRank" => $skybillRank,
            "evtCode" => "DC",
            "productCode" => $chronopostProductCode,
            "shipDate" => date('c'),
            "shipHour" => (int)date('G'),
            "weight" => $weight,
            "weightUnit" => "KGM",
            "service" => "0",
            "objectType" => "MAR", //Todo Change according to product ? Is any product a document instead of a marchandise ?
        ];

        /** SKYBILL PARAMETERS */
        $APIData["skybillParamsValue"] = [
            "mode" => $config[ChronopostConst::CHRONOPOST_LABEL_TYPE],
        ];

        /** OTHER PARAMETERS */
        $APIData["password"] = $config[ChronopostConst::CHRONOPOST_PASSWORD];
        $APIData["version"] = "2.0";

        /** EXPIRATION AND SELL-BY DATE (IN CASE OF FRESH PRODUCT) */
        if (in_array($chronopostProductCode, ["2R", "2P", "2Q", "2S", "3X", "3Y", "4V", "4W", "4X"])) {
            $APIData["scheduledValue"] = [
                "expirationDate" => date('c', mktime(0, 0, 0, date('m'), date('d') + (int)$config[ChronopostConst::CHRONOPOST_EXPIRATION_DATE], date('Y'))),
                "sellByDate" => date('c'),
            ];
        }

        return $APIData;
    }

    /**
     * Get the label file extension
     *
     * @param $labelType
     * @return string
     */
    private function getLabelExtension($labelType)
    {
        switch ($labelType) {
            case "PDF":
                return ".pdf";
                break;
            case "SPD":
                return ".pdf";
                break;
            case "THE":
                return ".pdf";
                break;
            case "Z2D":
                return ".zpl";
                break;
        }
        return ".pdf";
    }

    /**
     * Create the Chronopost label
     *
     * @param OrderEvent $orderEvent
     * @return null
     */
    public function createChronopostLabel(OrderEvent $orderEvent)
    {
        $order = $orderEvent->getOrder();
        $boxQuantity = 1;

        if (!$this->checkModule($order->getDeliveryModuleId())) {
            return false;
        }

        try {
            /** Check if order has status paid */
            if ($orderEvent->getStatus() != Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_TREATMENT_STATUS)) {
                return false;
            }

            $APIDatas = [];

            $reference = $order->getRef();
            $config = ChronopostConst::getConfig();

            $log = Tlog::getNewInstance();
            $log->setDestinations("\\Thelia\\Log\\Destination\\TlogDestinationFile");
            $log->setConfig("\\Thelia\\Log\\Destination\\TlogDestinationFile", 0, THELIA_ROOT . "log" . DS . "log-chronopost.txt");

            $log->notice("#CHRONOPOST // L'étiquette de la commande " . $reference . " est en cours de création.");

            /** Get order infos from table */
            $chronopostOrder = ChronopostOrderQuery::create()->filterByOrderId($order->getId())->findOne();

            for ($i = 1; $i <= $boxQuantity; $i++) {
                if ($chronopostOrder) {

                    if (1 == $i) {
                        $APIDatas[] = $this->writeAPIData($order, $order->getWeight(), $boxQuantity, $i);
                    } else {
                        $APIDatas[] = $this->writeAPIData($order, $order->getWeight(), $boxQuantity, $i);
                    }

                } else {
                    $log->error("#CHRONOPOST // Impossible de trouver la commande " . $reference . " dans la table des commandes Chronopost.");
                    return null;
                }
            }

            /** Send order informations to the Chronopost API */
            $soapClient = new \SoapClient(ChronopostConst::CHRONOPOST_SHIPPING_SERVICE_WSDL, array("trace" => 1, "exception" => 1));

            foreach ($APIDatas as $APIData) {

                $response = $soapClient->__soapCall('shippingV3', [$APIData]);

                if (0 != $response->return->errorCode) {
                    throw new \Exception($response->return->errorMessage);
                }

                /** Create the label accordingly */
                $label = $config[ChronopostConst::CHRONOPOST_LABEL_DIR] . $response->return->skybillNumber . self::getLabelExtension($config[ChronopostConst::CHRONOPOST_LABEL_TYPE]);

                if (false === @file_put_contents($label, $response->return->skybill)) {
                    $log->error("L'étiquette n'a pas pu être sauvegardée dans " . $label);
                } else {
                    $log->notice("L'étiquette Chronopost a été sauvegardée en tant que " . $response->return->skybillNumber . self::getLabelExtension($config[ChronopostConst::CHRONOPOST_LABEL_TYPE]));
                    $chronopostOrder
                        ->setLabelNumber($response->return->skybillNumber . self::getLabelExtension($config[ChronopostConst::CHRONOPOST_LABEL_TYPE]))
                        ->save();
                }
            }

        } catch (\Exception $e) {
            Tlog::getInstance()->addError("#CHRONOPOST // Error when trying to create the label. Chronopost response : " . $e->getMessage());
        }

        return null;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::ORDER_SET_DELIVERY_MODULE => array('setChronopostDeliveryType', 64),
            TheliaEvents::ORDER_BEFORE_PAYMENT => array('saveChronopostOrder', 256),
            TheliaEvents::ORDER_UPDATE_STATUS => array('createChronopostLabel', 257)
        );
    }
}