<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserNameBlockedKeywords extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return UserNameBlockedKeywordsValidator::class;
    }

}
