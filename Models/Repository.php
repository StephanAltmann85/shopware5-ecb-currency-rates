<?php

namespace saltyUpdateCurrencyRates\Models;

use Shopware\Components\Model\ModelRepository;
use Shopware\Models\Shop\Currency;


class Repository extends ModelRepository {

    /**
     * @return array
     */
    public function getWidgetData() {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $data = $qb->select(['currencies.currency', 'currencies.factor', '(currencies.factor - log.rate) / log.rate * 100', 'log.updated'])
            ->from(Currency::class, 'currencies')
            ->leftJoin(RateLog::class, 'log', \Doctrine\ORM\Query\Expr\Join::WITH, 'currencies.currency = log.currency')
            ->orderBy('log.updated', 'DESC')

            ->getQuery()
            ->getArrayResult();

        return $data;
    }
}