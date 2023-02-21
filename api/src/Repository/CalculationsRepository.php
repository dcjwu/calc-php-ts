<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Calculations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calculations>
 *
 * @method Calculations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calculations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calculations[]    findAll()
 * @method Calculations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calculations::class);
    }

    public function save(Calculations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Calculations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
