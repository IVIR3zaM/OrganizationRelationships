<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Validator
 */
class ObjectArrayValidator extends ConstraintValidator
{
    /**
     * @inheritdoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ObjectArray) {
            throw new UnexpectedTypeException($constraint, ObjectArray::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        $class = $constraint->class;

        foreach($value as $index => $item) {
            if (!$item instanceof $class) {
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ integer }}', $index)
                ->setParameter('{{ class }}', $class)
                ->addViolation();
            }
        }
    }
}
