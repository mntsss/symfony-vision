<?php

namespace App\Api\OptionParameter\Repository;

use App\Api\OptionParameter\Entity\OptionValueRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OptionValueRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionValueRelation::class);
    }
}
