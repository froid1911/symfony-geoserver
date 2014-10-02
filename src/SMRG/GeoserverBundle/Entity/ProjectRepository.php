<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    public function getWithRelated($id)
    {
        $builder = $this->createQueryBuilder('p');
        $builder->leftJoin('SMRGGeoserverBundle:Track', 't');
        $builder->where('p.id = :id');
        $builder->setParameter('id', $id);
        return $builder->getQuery()->getOneOrNullResult();

    }

}
