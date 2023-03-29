<?php

declare(strict_types=1);

namespace App\Repository;

use App\UseCase\User\List\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly PaginatorInterface $paginator,
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, User::class);
    }

    public function findAllWithFilter(Filter $filter, int $page = 1, int $limit = 25): PaginationInterface
    {
        $qb = $this->createQueryBuilder('u');

        if (null !== $filter->isActive) {
            $qb
                ->andWhere('u.isActive = :isActive')
                ->setParameter('isActive', (bool) $filter->isActive)
            ;
        }

        if (null !== $filter->isMember) {
            $qb
                ->andWhere('u.isMember = :isMember')
                ->setParameter('isMember', (bool) $filter->isMember)
            ;
        }

        if ($filter->userType) {
            $qb
                ->andWhere('u.userType IN (:userTypes)')
                ->setParameter('userTypes', $filter->userType)
            ;
        }

        if ($filter->lastLoginFrom) {
            $qb
                ->andWhere('u.lastLoginAt > :lastLoginFrom')
                ->setParameter('lastLoginFrom', $filter->lastLoginFrom)
            ;
        }

        if ($filter->lastLoginTo) {
            $qb
                ->andWhere('u.lastLoginAt < :lastLoginTo')
                ->setParameter('lastLoginTo', $filter->lastLoginTo)
            ;
        }

        $query = $qb->getQuery();

        return $this->paginator->paginate($query, $page, $limit);
    }
}
