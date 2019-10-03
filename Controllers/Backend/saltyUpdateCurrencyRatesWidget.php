<?php

use saltyUpdateCurrencyRates\Models\RateLog;

class Shopware_Controllers_Backend_saltyUpdateCurrencyRatesWidget extends Shopware_Controllers_Backend_ExtJs
{
    /**
    * Loads data for the backend widget
    */
    public function loadBackendWidgetAction()
    {
        $data = Shopware()->Models()->getRepository(RateLog::class)->getWidgetData();

        $this->View()->assign(array(
            'success' => true,
            'data' => $data
        ));
    }
}
