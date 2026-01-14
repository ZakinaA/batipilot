<?php

namespace App\Repository;

use App\Entity\ChantierPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChantierPoste>
 */
class ChantierPosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChantierPoste::class);
    }
    public function getTotauxParPoste(): array
{
    $qb = $this->createQueryBuilder('cp')
        ->select(
            'IDENTITY(cp.poste) AS poste_id',
            'COALESCE(SUM(cp.montantHT), 0) AS total_ht',
            'COALESCE(SUM(cp.montantTTC), 0) AS total_ttc'
        )
        ->groupBy('cp.poste');

    $result = $qb->getQuery()->getResult();

    $totaux = [];

    foreach ($result as $row) {
        $totaux[$row['poste_id']] = [
            'ht' => (float) $row['total_ht'],
            'ttc' => (float) $row['total_ttc'],
        ];
    }

    return $totaux;
}


    //    /**
    //     * @return ChantierPoste[] Returns an array of ChantierPoste objects
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

    //    public function findOneBySomeField($value): ?ChantierPoste
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
