<?php

namespace App\Repository;

use App\Entity\Pret;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pret>
 *
 * @method Pret|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pret|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pret[]    findAll()
 * @method Pret[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pret::class);
    }

    public function nombrePretParAdherentBy($idAdherent)
        {
            return $this->createQueryBuilder('p')
                ->select('count(p.id) AS nombrePret, a.nom, a.prenom')
                ->leftJoin('p.adherent', 'a')
                ->andWhere('p.adherent = :idAdherent')
                ->setParameter('idAdherent', $idAdherent)
                ->groupBy('a')
                ->orderBy('a.nom', 'ASC')
                ->getQuery()
                ->getResult();
        }  

}
