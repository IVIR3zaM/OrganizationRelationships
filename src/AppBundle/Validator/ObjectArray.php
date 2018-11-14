<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Validator
 * @codeCoverageIgnore
 */
class ObjectArray extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The {{ integer }} index object in array, is not a valid {{ class }}';

    /**
     * @var string
     */
    public $class;

    /**
     * @inheritdoc
     */
    public function getRequiredOptions()
    {
        return ['class'];
    }
}
