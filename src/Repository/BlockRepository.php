<?php

namespace App\Repository;

use App\Entity\Block;
use App\Model\BlockType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Block|null find($id, $lockMode = null, $lockVersion = null)
 * @method Block|null findOneBy(array $criteria, array $orderBy = null)
 * @method Block[]    findAll()
 * @method Block[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Block::class);
    }

    /**
     * @return Block[]
     */
    public function getBlockedKeywords(): array
    {
        return $this->findBy([
            'type' => BlockType::keyword(),
        ]);
    }

    /**
     * @return Block[]
     */
    public function getBlockedDomains(): array
    {
        return $this->findBy([
            'type' => BlockType::domain(),
        ]);
    }

}