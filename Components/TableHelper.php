<?php

namespace saltyUpdateCurrencyRates\Components;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\Output;

class TableHelper {

    /**
     * @param Output $output
     * @param array $currencies
     * @param array $rates
     */
    public static function createRatesTable(Output $output, array $currencies, array $rates) {
        $table = new Table($output);
        $lines = [];

        foreach($currencies as $currency) {
            $lines[] = array($currency->getCurrency(), $rates[$currency->getCurrency()], $currency->getFactor(), self::generateRateChangeOutput($rates[$currency->getCurrency()], $currency->getFactor()));
        }


        $table
            ->setHeaders(array('Currency', 'Value', 'Before', 'Change'))
            ->setRows($lines)
            ->render();
    }

    /**
     * @param float $new
     * @param float $old
     * @return int|string
     */
    public static function generateRateChangeOutput(float $new, float $old) {
        if(!$new || !$old) {
            return 0;
        }

        $diff = $new - $old;
        $percentage = self::calcDiffPercentage($new, $old);

        if ($diff > 0) {
            return " $diff (<fg=green;> $percentage%</>)";
        }

        if($diff === 0) {
            return ' ' . $diff;
        }

        return "$diff (<fg=red;>$percentage%</>)";

    }

    /**
     * @param float $new
     * @param float $old
     * @return float
     */
    public static function calcDiffPercentage(float $new, float $old) {
        $diff = $new - $old;

        return round($diff / $old * 100, 2);
    }

}