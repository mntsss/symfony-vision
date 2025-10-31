<?php

namespace App\Api\OptionParameter\Repository;

use App\Api\OptionParameter\Entity\OptionParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OptionParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionParameter::class);
    }
}
