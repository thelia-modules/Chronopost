<?php

namespace Chronopost\Loop;


use Chronopost\Model\ChronopostPrice;
use Chronopost\Model\ChronopostPriceQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class ChronopostLoop extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('area_id', null, true),
            Argument::createIntTypeArgument('delivery_mode_id', null, true)
        );
    }

    /**
     * @return ChronopostPriceQuery|\Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $areaId = $this->getAreaId();
        $modeId = $this->getDeliveryModeId();

        $areaPrices = ChronopostPriceQuery::create()
            ->filterByDeliveryModeId($modeId)
            ->filterByAreaId($areaId)
            ->orderByWeightMax();

        return $areaPrices;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var ChronopostPrice $price */
        foreach ($loopResult->getResultDataCollection() as $price) {
            $loopResultRow = new LoopResultRow($price);
            $loopResultRow
                ->set("SLICE_ID", $price->getId())
                ->set("MAX_WEIGHT", $price->getWeightMax())
                ->set("MAX_PRICE", $price->getPriceMax())
                ->set("PRICE", $price->getPrice())
                ->set("FRANCO", $price->getFrancoMinPrice())
            ;
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}