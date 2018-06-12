<?php

namespace Chronopost\Loop;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Chronopost\Model\ChronopostDeliveryModeQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class ChronopostDeliveryMode extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * Unused
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    /**
     * @return ChronopostDeliveryModeQuery|\Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $config = ChronopostConst::getConfig();
        $modes = ChronopostDeliveryModeQuery::create();

        $enabledDeliveryTypes[] = $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS] ? "01" : "";
        $enabledDeliveryTypes[] = $config[ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS] ? "2R" : "";
        /** @TODO Add other delivery types */

        $modes->filterByCode($enabledDeliveryTypes, Criteria::IN);

        return $modes;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \Chronopost\Model\ChronopostDeliveryMode $mode */
        foreach ($loopResult->getResultDataCollection() as $mode) {
            $loopResultRow = new LoopResultRow($mode);
            $loopResultRow
                ->set("ID", $mode->getId())
                ->set("TITLE", $mode->getTitle())
                ->set("CODE", $mode->getCode())
                ->set("FREESHIPPING_ACTIVE", $mode->getFreeshippingActive())
                ->set("FREESHIPPING_FROM", $mode->getFreeshippingFrom());
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}