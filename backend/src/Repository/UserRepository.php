<?php

namespace App\Repository;

use App\Entity\User;
use Domain\Entity\User as DomainUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\DataMapper\UserMapper;
use Domain\Port\Repository\UserRepositoryInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAll(): array
    {
        $users = [];
        foreach(parent::findAll() as $user) {
            $users[] = UserMapper::toDomainEntity($user);
        }

        return $users;
    }

    public function findById(string $id): ?DomainUser
    {
        $user = parent::find($id);
        if ($user === null) {
            return null;
        }

        return UserMapper::toDomainEntity($user);
    }

    public function findByUsername(string $username): ?DomainUser
    {
        $user = parent::findOneBy(['username' => $username]);
        if ($user === null) {
            return null;
        }

        return UserMapper::toDomainEntity($user);
    }

    public function findByEmail(string $email): ?DomainUser
    {
        $user = parent::findOneBy(['email' => $email]);
        if ($user === null) {
            return null;
        }

        return UserMapper::toDomainEntity($user);
    }

    public function create(DomainUser $user): DomainUser
    {
        $infraUser = UserMapper::toSymfonyEntity($user);

        $this->getEntityManager()->persist($infraUser);
        $this->getEntityManager()->flush();

        return UserMapper::toDomainEntity($infraUser);
    }

    public function update(DomainUser $user): DomainUser
    {
        $infraUser = $this->find($user->getId());

        $this->getEntityManager()->persist($infraUser);
        $this->getEntityManager()->flush();

        return UserMapper::toDomainEntity($infraUser);
    }

    public function delete(string $id): bool
    {
        $user = $this->find($id);
        if ($user === null) {
            return false;
        }

        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();

        return true;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
