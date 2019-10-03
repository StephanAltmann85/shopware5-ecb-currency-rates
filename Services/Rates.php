<?php

namespace saltyUpdateCurrencyRates\Services;

use saltyUpdateCurrencyRates\Models\RateLog;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Shop\Currency;

/**
 * Class Rates
 * @package saltyUpdateCurrencyRates\Services
 */
class Rates implements RatesServiceInterface {

    /**
     * @var ModelManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $targetEntity;

    /**
     * @var ConnectionServiceInterface
     */
    private $dataService;

    /**
     * Rates constructor.
     * @param ModelManager $models
     * @param string $targetEntity
     * @param ConnectionServiceInterface $dataService
     */
    public function __construct(ModelManager $models, string $targetEntity, ConnectionServiceInterface $dataService) {
        $this->entityManager = $models;
        $this->targetEntity = $targetEntity;
        $this->dataService = $dataService;
    }

    /**
     * @param array $currencies
     * @return array|null
     */
    public function get(array $currencies) {
        if(!count($currencies)) {
            return null;
        }

        $qb = $this->entityManager->getRepository($this->targetEntity)->createQueryBuilder('currencies');
        $result = $qb->where($qb->expr()->in('currencies.currency', $currencies))->getQuery()->getResult();

        return $result;
    }

    /**
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update() {
        $rates = $this->dataService->get();
        $currencies = $this->get(array_keys($rates));

        $this->updateRates($rates, $currencies);
    }

    /**
     * @param array $rates
     * @param array $currencies
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateRates(array $rates, array $currencies) {
        foreach ($currencies as $currency) {
            if($rates[$currency->getCurrency()] > 0 && $rates[$currency->getCurrency()] != $currency->getFactor()) {
                $this->updateRateLog($currency);

                $currency->setFactor($rates[$currency->getCurrency()]);
                $this->entityManager->persist($currency);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param Currency $currency
     */
    protected function updateRateLog(Currency $currency) {
        $entry = $this->getRateLog($currency->getCurrency());

        $entry->setRate($currency->getFactor());
        $this->entityManager->persist($entry);
    }

    /**
     * @param string $iso
     * @return null|object|RateLog
     */
    protected function getRateLog(string $iso) {
        $entry = $this->entityManager->getRepository(RateLog::class)->find($iso);

        if($entry === null) {
            $entry = new RateLog();
            $entry->setCurrency($iso);
        }

        return $entry;
    }

}