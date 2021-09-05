<?php

namespace App\DTO;

use App\Validator\Constraints\UserEmailBlockedDomains;
use App\Validator\Constraints\UserNameBlockedKeywords;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateDto
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-z0-9]+$/")
     * @Assert\Length(min="8")
     * @UserNameBlockedKeywords()
     */
    private $name;

    /**
     * @var string
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
     * @param string $name
     * @param string $email
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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