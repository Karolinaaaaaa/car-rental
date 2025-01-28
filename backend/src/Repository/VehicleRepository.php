<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findFilteredVehicles(?string $brand, ?bool $isRented): array
    {
        $queryBuilder = $this->createQueryBuilder('v');

        if ($brand) {
            $queryBuilder->andWhere('v.brand LIKE :brand')
                ->setParameter('brand', '%' . $brand . '%');
        }

        if ($isRented !== null) {
            $queryBuilder->andWhere('v.isRented = :isRented')
                ->setParameter('isRented', $isRented);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
