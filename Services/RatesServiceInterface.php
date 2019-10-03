<?php

namespace saltyUpdateCurrencyRates\Services;

/**
 * Class Rates
 * @package saltyUpdateCurrencyRates\Services
 */
interface RatesServiceInterface {

    public function get(array $currencies);

    public function update();

    public function updateRates(array $rates, array $currencies);


}