<?php

namespace saltyUpdateCurrencyRates\Services;

class EZBXML implements ParsingServiceInterface {

    /**
     * @param string $content
     * @return array|void
     */
    public function parse(string $content) {
        if(!$content) {
            return;
        }

        $rates = [];

        $xml = simplexml_load_string($content);

        foreach($xml->Cube->Cube->Cube as $rate) {
            $rates[$rate['currency']->__toString()] = (float)$rate['rate']->__toString();
        }

        return $rates;
    }
}