<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Controller;

use IVIR3zaM\OrganizationRelationships\AppBundle\Service\OrganizationRelationPagination;
use IVIR3zaM\OrganizationRelationships\AppBundle\Response\OrganizationRelationPaginator;
use IVIR3zaM\OrganizationRelationships\AppBundle\Service\OrganizationRequestHandler;
use IVIR3zaM\OrganizationRelationships\AppBundle\Request\OrganizationModel;
use IVIR3zaM\OrganizationRelationships\AppBundle\Response\SuccessState;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Controller\Annotations\Post as RestPost;
use FOS\RestBundle\Controller\Annotations\Get as RestGet;
use FOS\RestBundle\Controller\Annotations\QueryParam;
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
    const PAGINATION_SERVICE = 'app.service.organization_relation_pagination';

    /**
     * @var string
     */
    const REQUEST_HANDLER_SERVICE = 'app.service.organization_request_handler';

    /**
     * @RestGet("/organization/{id}/relations", requirements={"id"="\d+"}, name="organization_relations")
     * @ParamConverter("organization", class="AppBundle:Organization")
     * @QueryParam(name="page", requirements="\d+", default=1)
     * @QueryParam(name="perPage", requirements="\d+", default=100)
     * @QueryParam(name="orderColumn", requirements="(name|relation)", default="name")
     * @QueryParam(name="orderDirection", requirements="(ASC|DESC)", default="ASC")
     * @RestView()
     *
     * @param int $page
     * @param int $perPage
     * @param string $orderColumn
     * @param string $orderDirection
     * @param Organization $organization
     * @return OrganizationRelationPaginator
     */
    public function fetchRelationsAction(Organization $organization, int $page, int $perPage, string $orderColumn, string $orderDirection)
    {
        /** @var OrganizationRelationPagination $service */
        $service = $this->get(self::PAGINATION_SERVICE);

        $paginator = $service->getOrganizationRelationsPaginator($organization->getId(), $page, $perPage, $orderColumn, $orderDirection);

        return $paginator;
    }

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
