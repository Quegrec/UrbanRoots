<?php

namespace App\Repository;

use App\Entity\Topic;
use Domain\Entity\Topic as DomainTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\DataMapper\TopicMapper;
use Domain\Port\Repository\TopicRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Topic>
 */
class TopicRepository extends ServiceEntityRepository implements TopicRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function findAll(): array
    {
        $topics = [];
        foreach (parent::findAll() as $topic) {
            $topics[] = TopicMapper::toDomainEntity($topic);
        }

        return $topics;
    }

    public function findById(string $id): ?DomainTopic
    {
        $topic = parent::find($id);
        if ($topic === null) {
            return null;
        }

        return TopicMapper::toDomainEntity($topic);
    }

    public function findByTitle(string $title): ?DomainTopic
    {
        $topic = parent::findOneByTitle($title);
        if ($topic === null) {
            return null;
        }
        
        return TopicMapper::toDomainEntity($topic);
    }

    public function create(DomainTopic $topic): DomainTopic
    {
        $infraTopic = TopicMapper::toSymfonyEntity($topic);

        $this->getEntityManager()->persist($infraTopic);
        $this->getEntityManager()->flush();

        return TopicMapper::toDomainEntity($infraTopic);
    }

    public function delete(string $id): bool
    {
        $topic = parent::find($id);
        if ($topic === null) {
            return false;
        }

        $this->getEntityManager()->remove($topic);
        $this->getEntityManager()->flush();

        return true;
    }
    
//    /**
//     * @return Topic[] Returns an array of Topic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Topic
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
