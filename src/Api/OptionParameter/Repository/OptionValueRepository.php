<?php

namespace App\Api\OptionParameter\Repository;

use App\Api\OptionParameter\Entity\OptionValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OptionValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionValue::class);
    }

    /**
     * @return array<OptionValue>
     */
    public function findAllWithParameters(): array
    {
        $queryBuilder = $this->createQueryBuilder('ov')
            ->addSelect('op')
            ->join('ov.parameter', 'op');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array<string, string> $criteria
     *
     * @return array<int>
     */
    public function findOptionValueIdsByParameterNames(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('ov.idOptionValue')
            ->distinct()
            ->from(OptionValue::class, 'ov')
            ->join('ov.parameter', 'op');

        $i = 0;
        foreach ($criteria as $name => $value) {
            $queryBuilder->orWhere("op.name = :name$i AND ov.value = :value$i")
                ->setParameter("name$i", $name)
                ->setParameter("value$i", $value);
            $i++;
        }

        return $queryBuilder
            ->getQuery()
            ->getSingleColumnResult();
    }
}
