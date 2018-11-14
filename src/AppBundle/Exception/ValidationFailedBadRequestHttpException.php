<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Exception
 * @codeCoverageIgnore
 */
class ValidationFailedBadRequestHttpException extends BadRequestHttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * ValidationFailedBadRequestHttpException constructor.
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->constraintViolationList = $constraintViolationList;
        parent::__construct(sprintf('Validation failed with %d error(s).', count($constraintViolationList)));
    }
    
    /**
     * @codeCoverageIgnore
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList()
    {
        return $this->constraintViolationList;
    }
}
