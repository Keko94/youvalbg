<?php

namespace Tyras\NewsBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * NewsRepositoryODM
 *
 * This class was generated by the Doctrine ODM. Add your own custom
 * repository methods below.
 */
class NewsRepositoryODM extends DocumentRepository
{
    public function findPublishedNews($resType = 'result')
    {
        $qb = $this->createQueryBuilder('n');

        $qb->where('n.enabled = true')
            ->andWhere('n.date <= CURRENT_TIMESTAMP()')
            ->orderBy('n.date', 'DESC');


        if ($resType == 'result'){
            $qb->setMaxResults(5);
            return $qb->getQuery()->getResult();
        }
        else
            return $qb->getQuery();
    }
}
