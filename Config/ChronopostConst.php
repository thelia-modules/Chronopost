<?php

namespace Chronopost\Config;


use Chronopost\Chronopost;
use Thelia\Model\ConfigQuery;

class ChronopostConst
{
    /** Chronopost shipper identifiers */
    const CHRONOPOST_CODE_CLIENT_RELAIS             = "chronopost_code_relais";
    const CHRONOPOST_CODE_CLIENT                    = "chronopost_code";
    const CHRONOPOST_PASSWORD                       = "chronopost_password";

    /** Chronopost label type (PDF,ZPL | With or without proof of deposit */
    const CHRONOPOST_LABEL_TYPE                     = "chronopost_label_type";

    /** Directory where we save the label */
    const CHRONOPOST_LABEL_DIR                      = "chronopost_label_dir";

    /** ID of the treatment status in Thelia */
    const CHRONOPOST_TREATMENT_STATUS               = "chronopost_treatment_status";

    /** Send as customer status. */
    const CHRONOPOST_PRINT_AS_CUSTOMER_STATUS       = "chronopost_send_as_customer_status";

    /** Days before fresh products expiration after processing */
    const CHRONOPOST_EXPIRATION_DATE                = "chronopost_expiration_date";

    /** Status of the delivery types. Enabled|Disabled */
    const CHRONOPOST_FRESH_DELIVERY_13_STATUS       = "chronopost_fresh_delivery_13_status";
    const CHRONOPOST_DELIVERY_CHRONO_13_STATUS      = "chronopost_delivery_chrono_13_status";
    const CHRONOPOST_DELIVERY_CHRONO_18_STATUS      = "chronopost_delivery_chrono_18_status";
    const CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS  = "chronopost_delivery_chrono_13_bal_status";
    const CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS = "chronopost_delivery_chrono_classic_status";
    const CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS = "chronopost_delivery_chrono_express_status";
    /** @TODO Add other delivery types  */

    /** WSDL for the Chronopost Shipping Service */
    const CHRONOPOST_SHIPPING_SERVICE_WSDL              = "https://ws.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl";
    const CHRONOPOST_RELAY_SEARCH_SERVICE_WSDL          = "https://ws.chronopost.fr/recherchebt-ws-cxf/PointRelaisServiceWS?wsdl";
    const CHRONOPOST_COORDINATES_SERVICE_WSDL           = "https://ws.chronopost.fr/rdv-cxf/services/CreneauServiceWS?wsdl";
    /** @TODO Add other WSDL config key */

    /** @Unused */
    const CHRONOPOST_TRACKING_URL                   = "https://ws.chronopost.fr/tracking-cxf/TrackingServiceWS/trackSkybillV2";

    /** Shipper informations */
    const CHRONOPOST_SHIPPER_NAME1          = "chronopost_shipper_name1";
    const CHRONOPOST_SHIPPER_NAME2          = "chronopost_shipper_name2";
    const CHRONOPOST_SHIPPER_ADDRESS1       = "chronopost_shipper_address1";
    const CHRONOPOST_SHIPPER_ADDRESS2       = "chronopost_shipper_address2";
    const CHRONOPOST_SHIPPER_COUNTRY        = "chronopost_shipper_country";
    const CHRONOPOST_SHIPPER_CITY           = "chronopost_shipper_city";
    const CHRONOPOST_SHIPPER_ZIP            = "chronopost_shipper_zipcode";
    const CHRONOPOST_SHIPPER_CIVILITY       = "chronopost_shipper_civ";
    const CHRONOPOST_SHIPPER_CONTACT_NAME   = "chronopost_shipper_contact_name";
    const CHRONOPOST_SHIPPER_PHONE          = "chronopost_shipper_phone";
    const CHRONOPOST_SHIPPER_MOBILE_PHONE   = "chronopost_shipper_mobile_phone";
    const CHRONOPOST_SHIPPER_MAIL           = "chronopost_shipper_mail";

    /** @Unused */
    public function getTrackingURL()
    {
        $URL = self::CHRONOPOST_TRACKING_URL;
        $URL .= "language=" . "fr_FR"; //todo Make locale a variable
        $URL .= "&skybillNumber=" . "XXX"; //todo Use real skybill Number -> getTrackingURL(variable)

        return $URL;
    }

    /** Local static config value, used to limit the number of calls to the DB  */
    protected static $config = null;

    /**
     * Set the local static config value
     */
    public static function setConfig()
    {
        $config = [
            /** Chronopost basic informations */
            self::CHRONOPOST_CODE_CLIENT_RELAIS         => Chronopost::getConfigValue(self::CHRONOPOST_CODE_CLIENT_RELAIS),
            self::CHRONOPOST_CODE_CLIENT                => Chronopost::getConfigValue(self::CHRONOPOST_CODE_CLIENT),
            self::CHRONOPOST_LABEL_DIR                  => Chronopost::getConfigValue(self::CHRONOPOST_LABEL_DIR),
            self::CHRONOPOST_LABEL_TYPE                 => Chronopost::getConfigValue(self::CHRONOPOST_LABEL_TYPE),
            self::CHRONOPOST_PASSWORD                   => Chronopost::getConfigValue(self::CHRONOPOST_PASSWORD),
            self::CHRONOPOST_TREATMENT_STATUS           => Chronopost::getConfigValue(self::CHRONOPOST_TREATMENT_STATUS),
            self::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS   => Chronopost::getConfigValue(self::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS),
            self::CHRONOPOST_EXPIRATION_DATE            => Chronopost::getConfigValue(self::CHRONOPOST_EXPIRATION_DATE),

            /** Delivery types */
            self::CHRONOPOST_FRESH_DELIVERY_13_STATUS   => Chronopost::getConfigValue(self::CHRONOPOST_FRESH_DELIVERY_13_STATUS),
            self::CHRONOPOST_DELIVERY_CHRONO_13_STATUS  => Chronopost::getConfigValue(self::CHRONOPOST_DELIVERY_CHRONO_13_STATUS),
            self::CHRONOPOST_DELIVERY_CHRONO_18_STATUS  => Chronopost::getConfigValue(self::CHRONOPOST_DELIVERY_CHRONO_18_STATUS),
            self::CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS  => Chronopost::getConfigValue(self::CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS),
            self::CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS  => Chronopost::getConfigValue(self::CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS),
            self::CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS  => Chronopost::getConfigValue(self::CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS),
            /** @TODO Add other delivery types */

            /** Shipper informations */
            self::CHRONOPOST_SHIPPER_NAME1              => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_NAME1),
            self::CHRONOPOST_SHIPPER_NAME2              => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_NAME2),
            self::CHRONOPOST_SHIPPER_ADDRESS1           => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_ADDRESS1),
            self::CHRONOPOST_SHIPPER_ADDRESS2           => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_ADDRESS2),
            self::CHRONOPOST_SHIPPER_COUNTRY            => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_COUNTRY),
            self::CHRONOPOST_SHIPPER_CITY               => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_CITY),
            self::CHRONOPOST_SHIPPER_ZIP                => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_ZIP),
            self::CHRONOPOST_SHIPPER_CIVILITY           => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_CIVILITY),
            self::CHRONOPOST_SHIPPER_CONTACT_NAME       => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_CONTACT_NAME),
            self::CHRONOPOST_SHIPPER_PHONE              => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_PHONE),
            self::CHRONOPOST_SHIPPER_MOBILE_PHONE       => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_MOBILE_PHONE),
            self::CHRONOPOST_SHIPPER_MAIL               => Chronopost::getConfigValue(self::CHRONOPOST_SHIPPER_MAIL),

            /** END */
        ];

        /** Add a / to the end of the path for the label directory if it wasn't added manually */
        if (substr($config[self::CHRONOPOST_LABEL_DIR], -1) !== '/') {
            $config[self::CHRONOPOST_LABEL_DIR] .= '/';
        }

        /** Check if the label directory exists, create it if it doesn't */
        if (!is_dir($config[self::CHRONOPOST_LABEL_DIR])) {
            @mkdir($config[self::CHRONOPOST_LABEL_DIR]);
        }

        /** Set the local static config value */
        self::$config = $config;
    }

    /**
     * Return the local static config value or the value of a given parameter
     *
     * @param null $parameter
     * @return array|mixed|null
     */
    public static function getConfig($parameter = null)
    {
        /** Check if the local config value is set, and set it if it's not */
        if (null === self::$config) {
            self::setConfig();
        }

        /** Return the value of the config parameter given, or null if it wasn't set */
        if (null !== $parameter) {
            return (isset(self::$config[$parameter])) ? self::$config[$parameter] : null;
        }

        /** Return the local static config value */
        return self::$config;
    }


}