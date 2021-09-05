<?php

namespace App\Repository;

use App\Entity\ActionLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionLog[]    findAll()
 * @method ActionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionLog::class);
    }

    /**
     * @param ActionLog $actionLog
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ActionLog $actionLog): void
    {
        if (!$actionLog->getId()) {
            $this->getEntityManager()->persist($actionLog);
        }
        $this->getEntityManager()->flush();
    }
}
