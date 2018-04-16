<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\ExchangeRateRepository")
 * @ORM\Table(name="exchange_rates")
 */
class ExchangeRate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="trace", type="string", length=6)
     */
    private $trace;
    /**
     * @ORM\Column(name="value", type="float", length=12)
     */
    private $value;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @return mixed
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * @param $trace
     * @return $this
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }


}