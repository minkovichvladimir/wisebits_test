<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserEmailBlockedDomains extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return UserEmailBlockedDomainsValidator::class;
    }

}
