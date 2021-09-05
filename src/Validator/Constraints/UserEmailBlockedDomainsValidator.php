<?php

namespace App\Validator\Constraints;


use App\Repository\BlockRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserEmailBlockedDomainsValidator extends ConstraintValidator
{
    /**
     * @var BlockRepository
     */
    private $blockRepository;

    /**
     * @param BlockRepository $blockRepository
     */
    public function __construct(BlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param $email
     * @param Constraint $constraint
     * @throws UnexpectedTypeException
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public function validate($email, Constraint $constraint): void
    {
        if (!$constraint instanceof UserEmailBlockedDomains) {
            throw new UnexpectedTypeException($constraint, UserEmailBlockedDomains::class);
        }

        $blockedDomains = $this->blockRepository->getBlockedDomains();
        foreach ($blockedDomains as $blockedDomain) {
            if (mb_strpos($email, $blockedDomain->getName()) !== false) {
                $this->context
                    ->buildViolation('`email` is in the blocked domain list')
                    ->addViolation();
                break;
            }
        }

    }
}
