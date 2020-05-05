<?php

namespace Chronopost\Smarty\Plugins;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\CountryQuery;
use Thelia\Model\Coupon;
use Thelia\Model\CouponQuery;
use Thelia\Module\Exception\DeliveryException;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class ChronopostDeliveryType extends AbstractSmartyPlugin
{
    protected $request;
    protected $dispatcher;

    /**
     * ChronopostDeliveryType constructor.
     *
     * @param Request $request
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(Request $request, EventDispatcherInterface $dispatcher = null)
    {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return array|SmartyPluginDescriptor[]
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "chronopostDeliveryType", $this, "chronopostDeliveryType"),
            new SmartyPluginDescriptor("function", "chronopostDeliveryPrice", $this, "chronopostDeliveryPrice"),
        );
    }

    /**
     * @param $params
     * @param $smarty
     */
    public function chronopostDeliveryPrice($params, $smarty)
    {
        $deliveryMode = $params["delivery-mode"];
        $country = CountryQuery::create()->findOneById($params["country"]);

        $cartWeight = $this->request->getSession()->getSessionCart($this->dispatcher)->getWeight();
        $cartAmount = $this->request->getSession()->getSessionCart($this->dispatcher)->getTaxedAmount($country);

        try {

            $price = Chronopost::getPostageAmount(
                $country->getAreaId(),
                $cartWeight,
                $cartAmount,
                $deliveryMode
            );

            $consumedCouponsCodes = $this->request->getSession()->getConsumedCoupons();

            foreach ($consumedCouponsCodes as $consumedCouponCode)  {
                $coupon = CouponQuery::create()
                    ->filterByCode($consumedCouponCode)
                    ->findOne();

                /** @var Coupon $coupon */
                if(null  !== $coupon){
                    if($coupon->isRemovingPostage()){
                        $price = 0;
                    }
                }
            }

        } catch (DeliveryException $ex) {
            $smarty->assign('isValidMode', false);
        }

        $smarty->assign('deliveryModePrice', $price);

    }

    /**
     * @param $params
     * @param $smarty
     */
    public function chronopostDeliveryType($params, $smarty)
    {
        $smarty->assign('isFresh13Enabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS));
        $smarty->assign('isChrono13Enabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS));
        $smarty->assign('isChrono18Enabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_18_STATUS));
        $smarty->assign('isChrono13BalEnabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS));
        $smarty->assign('isChronoClassicEnabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS));
        $smarty->assign('isChronoExpressEnabled', (bool) Chronopost::getConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS));
        /** @TODO Add other types of delivery */
    }

}