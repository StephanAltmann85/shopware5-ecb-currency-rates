<?php

namespace saltyUpdateCurrencyRates\Subscriber;

use Enlight\Event\SubscriberInterface;
use saltyUpdateCurrencyRates\Services\RatesServiceInterface;

class Cron implements SubscriberInterface
{
    private $ratesService;

    public function __construct(RatesServiceInterface $ratesService)
    {
        $this->ratesService = $ratesService;
    }

    /**
    * @return array
    */
    public static function getSubscribedEvents()
    {
        return array(
            'Shopware_CronJob_UpdateCurrencyRates' => 'updateCurrencyRates',
        );
    }

    public function updateCurrencyRates(\Shopware_Components_Cron_CronJob $job)
    {
        $this->ratesService->update();
    }

}
