<?php

namespace App\Validator\Constraints;


use App\Repository\BlockRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserNameBlockedKeywordsValidator extends ConstraintValidator
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
     * @param $name
     * @param Constraint $constraint
     * @throws UnexpectedTypeException
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public function validate($name, Constraint $constraint): void
    {
        if (!$constraint instanceof UserNameBlockedKeywords) {
            throw new UnexpectedTypeException($constraint, UserNameBlockedKeywords::class);
        }

        $blockedKeywords = $this->blockRepository->getBlockedKeywords();
        foreach ($blockedKeywords as $blockedKeyword) {
            if (mb_strpos($name, $blockedKeyword->getName()) !== false) {
                $this->context
                    ->buildViolation(sprintf('`name` contains blocked word: %s', $blockedKeyword->getName()))
                    ->addViolation();
                break;
            }
        }

    }
}
