<?php

namespace AppBundle\Services;

use AppBundle\Entity\ExchangeRate;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ExchangeRateService
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $exchanges
     * @param $pubDate
     */
    public function storeRecords($exchanges, $pubDate)
    {
        foreach ($exchanges as $key => $trace) {
            if (!is_numeric($trace) && strlen($trace) > 0) {
                $date = new DateTime();
                $date->setTimestamp(strtotime($pubDate));
                $exchangeRate = $this->getExchangeRateRepo()->findOneBy(['date' => $date, 'trace' => $trace]);
                if (empty($exchangeRate)) {
                    $exchangeRate = new ExchangeRate();
                }
                $exchangeRate->setDate($date)
                    ->setTrace($trace)
                    ->setValue($exchanges[$key + 1]);
                $this->em->persist($exchangeRate);
                $this->em->flush();
                echo sprintf('Fetched data for: %s at %s', $trace, $pubDate) . PHP_EOL;
            }
        }
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getExchangeRateRepo()
    {
        return $this->em->getRepository(ExchangeRate::class);
    }
}