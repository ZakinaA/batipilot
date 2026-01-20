<?php

namespace App\Repository;

use App\Entity\Chantier;
use App\Entity\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chantier>
 */
class ChantierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chantier::class);
    }

    public function updateStatutsByDates(): void
    {
        $em = $this->getEntityManager();
        $today = new \DateTimeImmutable('today');

        $chantiers = $this->createQueryBuilder('c')
            ->leftJoin('c.statut', 's')
            ->addSelect('s')
            ->where('c.archive = 0')
            ->getQuery()
            ->getResult();

        foreach ($chantiers as $chantier) {

        
           
            if ($chantier->getDateFin() !== null && $chantier->getDateFin() < $today) {
                $statutId = 3;
            }
          
            elseif (
                $chantier->getDateDemarrage() !== null &&
                $chantier->getDateDemarrage() <= $today
            ) {
                $statutId = 1;
            }
           
            else {
                $statutId = 2;
            }

            if ($chantier->getStatut()?->getId() !== $statutId) {
                $chantier->setStatut(
                    $em->getReference(\App\Entity\Statut::class, $statutId)
                );
            }
        }

        $em->flush();
    }


    /**
     * Récupération des chantiers par statut
     */
    public function findChantiersByStatutId(int $statutId): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.statut', 's')
            ->where('s.id = :statutId')
            ->andWhere('c.archive = 0')
            ->setParameter('statutId', $statutId)
            ->orderBy('c.dateDemarrage', 'ASC')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Chantier[] Returns an array of Chantier objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Chantier
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
