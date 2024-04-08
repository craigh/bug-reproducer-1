<?php

namespace App\Repository;

use App\Entity\SpecialPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpecialPerson>
 *
 * @method SpecialPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialPerson[]    findAll()
 * @method SpecialPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialPerson::class);
    }

    public function save(SpecialPerson $person): void
    {
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();
    }
}
