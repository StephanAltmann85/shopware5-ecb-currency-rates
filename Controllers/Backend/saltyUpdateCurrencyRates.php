<?php

class Shopware_Controllers_Backend_saltyUpdateCurrencyRates extends Shopware_Controllers_Backend_ExtJs
{
    public function indexAction() {

    }

    public function updateAction() {
        Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();

        Shopware()->Container()->get('salty_update_currency_rates.services.rates')->update();
    }
}
