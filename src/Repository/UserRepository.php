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

        if (null !== $filter->is_active) {
            $qb
                ->andWhere('u.isActive = :isActive')
                ->setParameter('isActive', (bool) $filter->is_active)
            ;
        }

        if (null !== $filter->is_member) {
            $qb
                ->andWhere('u.isMember = :isMember')
                ->setParameter('isMember', (bool) $filter->is_member)
            ;
        }

        if ($filter->user_type) {
            $qb
                ->andWhere('u.userType IN (:userTypes)')
                ->setParameter('userTypes', $filter->user_type)
            ;
        }

        if ($filter->last_login_from) {
            $qb
                ->andWhere('u.lastLoginAt > :lastLoginFrom')
                ->setParameter('lastLoginFrom', $filter->last_login_from)
            ;
        }

        if ($filter->last_login_to) {
            $qb
                ->andWhere('u.lastLoginAt < :lastLoginTo')
                ->setParameter('lastLoginTo', $filter->last_login_to)
            ;
        }

        $query = $qb->getQuery();

        return $this->paginator->paginate($query, $page, $limit);
    }
}
