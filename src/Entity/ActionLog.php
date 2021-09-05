<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActionLogRepository;

/**
 * @ORM\Entity(repositoryClass=ActionLogRepository::class)
 * @ORM\Table(name="action_log")
 */
class ActionLog
{
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';


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
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

    /**
     * @var string|null
     *
     * @ORM\Column(name="before", type="text", nullable=true)
     */
    private $before;

    /**
     * @var string|null
     *
     * @ORM\Column(name="after", type="text", nullable=true)
     */
    private $after;

    /**
     * @param string $source
     * @param string $action
     * @param string|null $before
     * @param string|null $after
     */
    public function __construct(string $source, string $action, ?string $before, ?string $after)
    {
        $this->source = $source;
        $this->action = $action;
        $this->before = $before;
        $this->after = $after;
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
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getBefore(): ?string
    {
        return $this->before;
    }

    /**
     * @return string|null
     */
    public function getAfter(): ?string
    {
        return $this->after;
    }
}