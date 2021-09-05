<?php

namespace App\DTO;

use App\Validator\Constraints\UserEmailBlockedDomains;
use App\Validator\Constraints\UserNameBlockedKeywords;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-z0-9]+$/")
     * @Assert\Length(min="8")
     * @UserNameBlockedKeywords()
     */
    private $name;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\Email(normalizer="trim")
     * @UserEmailBlockedDomains()
     */
    private $email;

    /**
     * @var string|null
     */
    private $notes;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }
}