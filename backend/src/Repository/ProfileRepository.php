<?php

namespace App\Repository;

use App\Entity\Profile;
use App\Entity\User;
use Domain\Entity\Profile as DomainProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\DataMapper\ProfileMapper;
use Domain\Port\Repository\ProfileRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Profile>
 *
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository implements ProfileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function create(DomainProfile $profile): DomainProfile
    {
        $user = $this->getEntityManager()->getRepository(User::class)
            ->find($profile->getUser()->getId());
        $infraProfile = ProfileMapper::toSymfonyEntity($profile, $user);
        $this->getEntityManager()->persist($infraProfile);
        $this->getEntityManager()->flush();

        return $profile;
    }

    public function update(DomainProfile $profile): DomainProfile
    {
        $infraProfile = ProfileMapper::toSymfonyEntity($profile);
        $this->getEntityManager()->persist($infraProfile);
        $this->getEntityManager()->flush();

        return $profile;
    }

    public function delete(string $id): bool
    {
        $profile = $this->find($id);
        if ($profile === null) {
            return false;
        }

        $this->getEntityManager()->remove($profile);
        $this->getEntityManager()->flush();

        return true;
    }

    public function findById(string $id): ?DomainProfile
    {
        $profile = $this->find($id);

        return $profile ? ProfileMapper::toDomainEntity($profile) : null;
    }

    public function findByUserId(string $userId): ?DomainProfile
    {
        $profile = $this->find($userId);
        
        return $profile ? ProfileMapper::toDomainEntity($profile) : null;
    }
    

    //    /**
    //     * @return Profile[] Returns an array of Profile objects
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

    //    public function findOneBySomeField($value): ?Profile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
