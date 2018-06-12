<?php

namespace Chronopost\Loop;


use Chronopost\Model\ChronopostOrder;
use Chronopost\Model\ChronopostOrderQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\OrderQuery;

class ChronopostExportLabelLoop extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createAnyTypeArgument('order_ref'),
            Argument::createAnyTypeArgument('delivery_code'),
            Argument::createAnyTypeArgument('delivery_type'),
            Argument::createAnyTypeArgument('label_number'),
            Argument::createAnyTypeArgument('label_directory')
        );
    }

    /**
     * @return ChronopostOrderQuery|\Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $orderRef       = self::getOrderRef();
        $deliveryType   = self::getDeliveryType();
        $deliveryCode   = self::getDeliveryCode();
        $labelNbr       = self::getLabelNumber();
        $labelDir       = self::getLabelDirectory();

        if (!is_null($orderRef)) {
            $orderId = OrderQuery::create()->filterByRef($orderRef)->findOne();
        }

        $chronopostOrder = ChronopostOrderQuery::create();

        if (!is_null($orderId)) {
            $chronopostOrder->filterByOrderId($orderId);
        }

        if (!is_null($deliveryType)) {
            $chronopostOrder->filterByDeliveryType($deliveryType);
        }

        if (!is_null($deliveryCode)) {
            $chronopostOrder->filterByDeliveryCode($deliveryCode);
        }

        if (!is_null($labelNbr)) {
            $chronopostOrder->filterByLabelNumber($labelNbr);
        }

        if (!is_null($labelDir)) {
            $chronopostOrder->filterByLabelDirectory($labelDir);
        }

        $chronopostOrder->orderById(Criteria::DESC);

        return $chronopostOrder;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var ChronopostOrder $chronopostOrder */
        foreach ($loopResult->getResultDataCollection() as $chronopostOrder) {

            /** @var  $loopResultRow */
            $loopResultRow = new LoopResultRow($chronopostOrder);

            $loopResultRow
                ->set("REFERENCE", OrderQuery::create()->filterById($chronopostOrder->getOrderId())->findOne()->getRef())
                ->set("DELIVERY_CODE", $chronopostOrder->getDeliveryCode())
                ->set("DELIVERY_TYPE", $chronopostOrder->getDeliveryType())
                ->set("LABEL_NBR", $chronopostOrder->getLabelNumber())
                ->set("LABEL_DIR", $chronopostOrder->getLabelDirectory())
                ->set("ORDER_ID", $chronopostOrder->getOrderId())
                ;
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}