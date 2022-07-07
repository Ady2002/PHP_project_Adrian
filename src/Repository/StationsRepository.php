<?php

namespace App\Repository;

use App\Entity\Stations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stations>
 *
 * @method Stations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stations[]    findAll()
 * @method Stations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stations::class);
    }

    public function add(Stations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Stations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

    }
	public function findStations(): array {
		$stat  = $this->getEntityManager()->getConnection();
		$sql  = 'SELECT DISTINCT Station_Type FROM Stations ORDER BY Station_Type';

		$stmt = $stat->prepare( $sql );
		$resultSet = $stmt->executeQuery();
		return $resultSet->fetchAllAssociative();
	}

	public function filterStations($City,$Type):array{

		$sql = 'SELECT sta FROM App\Entity\Stations sta INNER JOIN App\Entity\Locations loc WHERE loc.City = ?1 AND sta.Station_Type = ?2 AND sta.Location_ID = loc';
		return $this->getEntityManager()->createQuery($sql)->setParameter(2, $Type)->setParameter(1,$City)->getResult();
	}

//    /**
//     * @return Stations[] Returns an array of Stations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Stations
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
