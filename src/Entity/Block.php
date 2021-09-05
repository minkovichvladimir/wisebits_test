<?php

namespace App\Entity;

use App\Model\BlockType;
use App\Repository\BlockRepository;
use Doctrine\ORM\Mapping as ORM;
use UnexpectedValueException;

/**
 * @ORM\Entity(repositoryClass=BlockRepository::class)
 * @ORM\Table(name="blocks")
 */
class Block
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @param string $type
     * @param string $name
     */
    public function __construct(string $type, string $name)
    {
        if (!BlockType::validate($type)) {
            throw new UnexpectedValueException(sprintf('Unexpected BlockType: %s', $type));
        }
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}