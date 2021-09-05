<?php

namespace App\DataFixtures;

use App\Entity\Block;
use App\Model\BlockType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlockFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $block = new Block(BlockType::domain(),'blocked.io');
        $manager->persist($block);

        $block = new Block(BlockType::keyword(),'blocked');
        $manager->persist($block);

        $manager->flush();
    }
}
