<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\EventListener;

use IVIR3zaM\OrganizationRelationships\AppBundle\Exception\ValidationFailedBadRequestHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\EventListener
 * @codeCoverageIgnore
 */
class ControllerArgumentConstraintViolationListEventListener
{
    /**
     * @param FilterControllerArgumentsEvent $event
     */
    public function onControllerArgumentsHandle(FilterControllerArgumentsEvent $event)
    {
        foreach ($event->getArguments() as $argument) {
            if ($argument instanceof ConstraintViolationListInterface && count($argument) > 0) {
                throw new ValidationFailedBadRequestHttpException($argument);
            }
        }
    }
}
