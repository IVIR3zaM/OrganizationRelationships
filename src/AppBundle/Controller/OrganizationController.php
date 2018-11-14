<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Controller;

use IVIR3zaM\OrganizationRelationships\AppBundle\Service\OrganizationRequestHandler;
use IVIR3zaM\OrganizationRelationships\AppBundle\Request\OrganizationModel;
use IVIR3zaM\OrganizationRelationships\AppBundle\Response\SuccessState;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Controller\Annotations\Post as RestPost;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Controller
 */
class OrganizationController extends FOSRestController
{
    /**
     * @var string
     */
    const REQUEST_HANDLER_SERVICE = 'app.service.organization_request_handler';

    /**
     * @RestPost("/organization", name="organization")
     * @ParamConverter("organization", converter="fos_rest.request_body")
     * @RestView()
     *
     * @param OrganizationModel $organization
     * @return SuccessState
     */
    public function postAction(OrganizationModel $organization, ConstraintViolationListInterface $validationErrors)
    {
        /** @var OrganizationRequestHandler $service */
        $service = $this->get(self::REQUEST_HANDLER_SERVICE);

        $service->handle($organization);

        return new SuccessState();
    }
}
