<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class ExchangeRateRepository extends EntityRepository
{
    /**
     * @param string $alias
     * @param null $indexBy
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }

    /**
     * @param $from
     * @param $length
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getExchangeData($from, $length)
    {
        $data = $this->createQueryBuilder('o')
            ->getQuery()
            ->setFirstResult($from)
            ->setMaxResults($length)
            ->getArrayResult();
        $response['data'] = [];
        $records = $this->getRecordCount();
        $response['recordsTotal'] = $records;
        $response['recordsFiltered'] = $records;
        foreach ($data as $entry) {
            array_push($response['data'], [$entry['trace'], $entry['value'], $entry['date']->format('Y-m-d H:i')]);
        }
        return $response;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRecordCount()
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}