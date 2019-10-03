<?php

namespace saltyUpdateCurrencyRates\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="salty_rates_log")
 * @ORM\Entity(repositoryClass="Repository")
 * @ORM\HasLifecycleCallbacks
 */
class RateLog extends ModelEntity {

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", nullable=false)
     * @ORM\Id
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float", nullable=false)
     */
    private $rate;

    /**
     * @var \datetime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdateTime()
    {
        $this->updated = new \DateTime();
    }


    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @return \datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @param $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }


}