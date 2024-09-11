<?php

namespace App\Repository;

use App\Entity\Post;
use Domain\Entity\Post as DomainPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\DataMapper\PostMapper;
use Domain\Port\Repository\PostRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAll(): array // we never know when this could become useful
    {
        $posts = [];
        foreach (parent::findAll() as $post) {
            $posts[] = PostMapper::toDomainEntity($post);
        }

        return $posts;
    }

    public function findById(string $id): ?DomainPost
    {
        $post = parent::find($id);
        if ($post === null) {
            return null;
        }

        return PostMapper::toDomainEntity($post);
    }

    public function findByTopicId(string $topicId): array
    {
        $posts = [];
        foreach (parent::findBy(['topic' => $topicId]) as $post) {
            $posts[] = PostMapper::toDomainEntity($post);
        }

        return $posts;
    }

    public function findByParentId(string $parentId): array // in case of responding to an existing post
    {
        $posts = [];
        foreach (parent::findBy(['parentId' => $parentId]) as $post) {
            $posts[] = PostMapper::toDomainEntity($post);
        }

        return $posts;
    }
    
    public function create(DomainPost $post): DomainPost
    {
        $infraPost = PostMapper::toSymfonyEntity($post);

        $this->getEntityManager()->persist($infraPost);
        $this->getEntityManager()->flush();

        return PostMapper::toDomainEntity($infraPost);
    }

    public function update(DomainPost $post): DomainPost
    {
        $infraPost = PostMapper::toSymfonyEntity($post);

        $this->getEntityManager()->persist($infraPost);
        $this->getEntityManager()->flush();

        return PostMapper::toDomainEntity($infraPost);
    }

    public function delete(string $id): bool
    {
        $post = parent::find($id);
        if ($post === null) {
            return false;
        }

        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();

        return true;
    }    
    
//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
