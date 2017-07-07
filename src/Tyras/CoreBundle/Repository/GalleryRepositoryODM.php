<?php

namespace Tyras\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Query\Builder;


class GalleryRepositoryODM extends DocumentRepository
{
    /*public function findPublishedNews($resType = 'result')
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
    }*/
}
