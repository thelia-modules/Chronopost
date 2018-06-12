<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Chronopost;

use Chronopost\Config\ChronopostConst;
use Chronopost\Model\ChronopostAreaFreeshippingQuery;
use Chronopost\Model\ChronopostDeliveryMode;
use Chronopost\Model\ChronopostDeliveryModeQuery;
use Chronopost\Model\ChronopostPriceQuery;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Install\Database;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Country;
use Thelia\Model\ModuleQuery;
use Thelia\Module\AbstractDeliveryModule;
use Thelia\Module\BaseModule;
use Thelia\Module\Exception\DeliveryException;

class Chronopost extends AbstractDeliveryModule
{
    /** @var string */
    const DOMAIN_NAME = 'chronopost';

    /**
     * @param ConnectionInterface|null $con
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        try {
            /** Security to not erase user configuration on reactivation */
            ChronopostDeliveryModeQuery::create()->findOne();
            ChronopostAreaFreeshippingQuery::create()->findOne();
        } catch (\Exception $e) {
            $database = new Database($con->getWrappedConnection());
            $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));
        }

        $defaultConfig = [
            ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS          => null,
            ChronopostConst::CHRONOPOST_CODE_CLIENT                 => null,
            ChronopostConst::CHRONOPOST_LABEL_DIR                   => THELIA_LOCAL_DIR . 'chronopost',
            ChronopostConst::CHRONOPOST_LABEL_TYPE                  => "PDF",
            ChronopostConst::CHRONOPOST_PASSWORD                    => null,
            ChronopostConst::CHRONOPOST_TREATMENT_STATUS            => "3",
            ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS    => "N",
            ChronopostConst::CHRONOPOST_EXPIRATION_DATE             => null,

            ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS    => false,
            ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS   => false,
            /** @TODO Add other delivery types */

            ChronopostConst::CHRONOPOST_SHIPPER_NAME1               => null,
            ChronopostConst::CHRONOPOST_SHIPPER_NAME2               => null,
            ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1            => ConfigQuery::read("store_address1"),
            ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2            => ConfigQuery::read("store_address2"),
            ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY             => null,
            ChronopostConst::CHRONOPOST_SHIPPER_CITY                => ConfigQuery::read("store_city"),
            ChronopostConst::CHRONOPOST_SHIPPER_ZIP                 => ConfigQuery::read("store_zipcode"),
            ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY            => null,
            ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME        => null,
            ChronopostConst::CHRONOPOST_SHIPPER_PHONE               => ConfigQuery::read("store_phone"),
            ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE        => null,
            ChronopostConst::CHRONOPOST_SHIPPER_MAIL                => ConfigQuery::read("store_email"),
        ];

        /** Set the default config values in the DB table */
        foreach ($defaultConfig as $key => $value) {
            if (null === self::getConfigValue($key, null)) {
                self::setConfigValue($key, $value);
            }
        }

        /** Check if the path given is a directory, create it otherwise */
        $dir = self::getConfigValue(ChronopostConst::CHRONOPOST_LABEL_DIR, null);
        if (!is_dir($dir)) {
            @mkdir($dir);
        }

        /** @TODO : Add other delivery types code and titles */
        $deliveryTypes = [
            "01"     => "Chrono13",
            "2R"    => "Fresh13",
        ];

        /** Set the delivery types as not enabled when activating the module for the first time */
        foreach ($deliveryTypes as $code => $title) {
            if (null === self::isDeliveryTypeSet($code)) {
                self::setDeliveryType($code, $title);
            }
        }

    }

    /**
     * Check if a given delivery type exists in the ChronopostDeliveryMode table
     *
     * @param $code
     * @return ChronopostDeliveryMode
     */
    public function isDeliveryTypeSet($code)
    {
        return ChronopostDeliveryModeQuery::create()->findOneByCode($code);
    }

    /**
     * Add a delivery type to the ChronopostDeliveryMode table
     *
     * @param $code
     * @param $title
     */
    public function setDeliveryType($code, $title)
    {
        $newDeliveryType = new ChronopostDeliveryMode();

        try {
            $newDeliveryType
                ->setCode($code)
                ->setTitle($title)
                ->setFreeshippingActive(false)
                ->setFreeshippingFrom(null)
                ->save();
        } catch (\Exception $e) {

        }
    }

    /**
     * Verify if the are asked by the user is in the list of areas added to the shipping zones
     *
     * @param Country $country
     * @return bool
     */
    public function isValidDelivery(Country $country)
    {
        /** @TODO Change to CountryArea which is not deprecated */
        $areaId = $country->getAreaId();

        $prices = ChronopostPriceQuery::create()
            ->filterByAreaId($areaId)
            ->findOne();

        $freeShipping = ChronopostDeliveryModeQuery::create()
            ->findOneByFreeshippingActive(true);

        /** Check if Chronopost delivers in the asked area */
        if (null !== $prices || null !== $freeShipping) {
            return true;
        }
        return false;
    }


    /**
     * Return the delivery type of an ongoing order.
     *
     * @param Request|Session $request
     * @param boolean $continue
     * @return null|string
     */
    public function getDeliveryType($request, $continue)
    {
        static $x = 0;

        $fresh13 = $request->get('chronopost-fresh13');
        $chrono13 = $request->get('chronopost-chrono13');
        /** @TODO Add other delivery types here */

        if ($chrono13) {
            return "01";
        } elseif ($fresh13) {
            return "2R";
        } elseif ($continue) {
            switch ($x) {
                case 0:
                    $r = "01";
                    break;
                case 1:
                    $r = "2R";
                    break;
                default:
                    $r = null;
                    break;
            }
            $x++;
        } else {
            return null;
        }

        return $r;
    }

    /**
     * Return the postage price for a given area, cart weight, cart amount, and delivery type
     *
     * @param $areaId
     * @param $weight
     * @param int $cartAmount
     * @param null $deliveryType
     * @return int
     */
    public static function getPostageAmount($areaId, $weight, $cartAmount = 0, $deliveryType = null)
    {
        if (null === $deliveryType) {
            /** If no delivery type was given, take the first one found as default */
            $deliveryType = ChronopostDeliveryModeQuery::create()->find()->getFirst();
        } else {
            $deliveryType = ChronopostDeliveryModeQuery::create()->findOneByCode($deliveryType);
        }

        /** Check if freeshipping is activated for this delivery type */

        try {
            $freeShipping = $deliveryType->getFreeshippingActive();
        } catch (\Exception $e) {
            $freeShipping = false;
        }

        /** Get the total cart price needed to have a free shipping for all areas, if it exists */

        try {
            $freeShippingFrom = $deliveryType->getFreeshippingFrom();
        } catch (\Exception $er) {
            $freeShippingFrom = null;
        }

        /** Set the initial postage price as free (0) */
        $postage = 0;

        /** If free shipping is enabled, skip and return 0 */
        if (!$freeShipping) {

            /** If a minimum price for free shipping is defined and the amount of the cart reach this limit, return 0. */
            if (null !== $freeShippingFrom && $freeShippingFrom <= $cartAmount) {
                return $postage;
            }

            /** Search the list of prices and order it in ascending order */
            $areaPrices = ChronopostPriceQuery::create()
                ->filterByDeliveryModeId($deliveryType->getId())
                ->filterByAreaId($areaId)
                ->filterByWeightMax($weight, Criteria::GREATER_EQUAL)
                ->_or()
                ->filterByWeightMax(null)
                ->filterByPriceMax($cartAmount, Criteria::GREATER_EQUAL)
                ->_or()
                ->filterByPriceMax(null)
                ->orderByWeightMax()
                ->orderByPriceMax();

            /** Find the correct postage price for the cart weight according to the area and delivery mode in $areaPrices*/
            $firstPrice = $areaPrices->find()
                ->getFirst();

            /** If no price was found, throw an error */
            if (null === $firstPrice) {
                throw new DeliveryException("Chronopost delivery unavailable for your cart weight or delivery country");
            }

            /** Get the minimum price for free shipping in the area of the order */
            $cartAmountFreeShipping = ChronopostAreaFreeshippingQuery::create()
                ->filterByAreaId($areaId)
                ->filterByDeliveryModeId($deliveryType->getId())
                ->findOne();

            if (null !== $cartAmountFreeShipping) {
                $cartAmountFreeShipping->getCartAmount();
            }

            /** If the cart price is superior to the minimum price for free shipping in the area of the order,
             * return the postage as free.
             */
            if ($cartAmountFreeShipping !== null && $cartAmountFreeShipping <= $cartAmount) {
                return $postage;
            }
            $postage = $firstPrice->getPrice();
        }
        return $postage;
    }

    /**
     * Return the minimum postage price of a list of areas, for a given cart weight, price, and delivery type.
     *
     * @param $areaIdArray
     * @param $cartWeight
     * @param $cartAmount
     * @param $deliveryType
     * @return int|null
     */
    private function getMinPostage($areaIdArray, $cartWeight, $cartAmount, $deliveryType)
    {
        $minPostage = null;

        foreach ($areaIdArray as $areaId) {
            try {
                $postage = self::getPostageAmount($areaId, $cartWeight, $cartAmount, $deliveryType);
                if ($minPostage === null || $postage < $minPostage) {
                    $minPostage = $postage;
                    if ($minPostage == 0) {
                        break;
                    }
                }
            } catch (\Exception $ex) {
            }
        }

        return $minPostage;
    }


    /**
     * Return the postage of an ongoing order, or the minimum expected postage before the user chooses what delivery types he wants.
     *
     * @param Country $country
     * @return float|int|\Thelia\Model\OrderPostage
     */
    public function getPostage(Country $country)
    {
        $request = $this->getRequest();

        $cartWeight = $request->getSession()->getSessionCart($this->getDispatcher())->getWeight();
        $cartAmount = $request->getSession()->getSessionCart($this->getDispatcher())->getTaxedAmount($country);

        $deliveryType = 0;
        $postageResult = null;
        $continue = true;

        /** If no delivery type was given, the loop should continue until the postage for each delivery types was
         *  found, then return the minimum one. Otherwise, the loop should stop after the first iteration.
         */
        while (null !== $deliveryType && true === $continue)
        {
            /** Get the delivery type of an ongoing order by looking at the request */
            $deliveryType = self::getDeliveryType($request, false);

            /** If no delivery type was found, search again in the session. If none is found again, get
             *  the first one that wasn't already used.
             *  Otherwise, set @var bool $continue as false so the loop will stop after this iteration.
             */
            if (null == $deliveryType) {
                $session = $request->getSession();
                $deliveryType = self::getDeliveryType($session, true);
            } else {
                $continue = false;
            }

            /** Check what areas are covered in the shipping zones defined by the admin */
            $areaIdArray = self::getAllAreasForCountry($country);
            if (empty($areaIdArray)) {
                throw new DeliveryException("Your delivery country is not covered by Chronopost");
            }

            /** Get the postage for the shipping zones we've just got */
            $postage = null;
            if (null === $postage = self::getMinPostage($areaIdArray, $cartWeight, $cartAmount, $deliveryType)) {
                $postage = self::getMinPostage($areaIdArray, $cartWeight, $cartAmount, "chrono13");
                if (null === $postage) {
                    throw new DeliveryException("Chronopost delivery unavailable for your cart weight or delivery country");
                }
            }

            /** In case of multiple postages, when displaying the expected price, for example, makes sure the minimum
             *  postage is displayed instead of the last found.
             */
            if (null === $postageResult) {
                $postageResult = $postage;
            } elseif ($postage < $postageResult) {
                $postageResult = $postage;
            }
        }

        /** If delivery is free, set it to a minimal number so the price will still appear. It will be rounded up to 0 */
        if (null === $postageResult || 0 == $postageResult) {
            $postageResult = 0.000001;
        }

        return $postageResult;
    }

    /**
     * Returns ids of area containing this country and covers by this module
     * @param Country $country
     * @return array Area ids
     */
    private function getAllAreasForCountry(Country $country)
    {
        $areaArray = [];

        $sql = "SELECT ca.area_id as area_id FROM country_area ca
               INNER JOIN area_delivery_module adm ON (ca.area_id = adm.area_id AND adm.delivery_module_id = :p0)
               WHERE ca.country_id = :p1";

        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':p0', $this->getModuleModel()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':p1', $country->getId(), PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $areaArray[] = $row['area_id'];
        }

        return $areaArray;
    }
}
