<?php


namespace App\Validator;


use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Trait ValidatorMessagesTrait
 */
trait ValidatorMessagesTrait
{
    /**
     * @param ConstraintViolationListInterface|null $violationList
     * @throws InvalidArgumentException
     */
    private function messageViolationHandle(?ConstraintViolationListInterface $violationList): void
    {
        if (count($violationList)) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violationList as $violation) {
                throw new InvalidArgumentException($violation->getMessage());
            }
        }
    }
}
