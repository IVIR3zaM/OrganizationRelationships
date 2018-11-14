<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Service;

use IVIR3zaM\OrganizationRelationships\AppBundle\Response\OrganizationRelationPaginator;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRepository;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Service
 */
class OrganizationRelationPagination
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var int
     */
    private $maxResults;

    /**
     * @param EntityManagerInterface $entityManager
     * @param int $maxResults
     */
    public function __construct(EntityManagerInterface $entityManager, int $maxResults)
    {
        $this->entityManager = $entityManager;
        $this->maxResults = $maxResults;
    }

    /**
     * @param int $organizationId
     * @param int $page
     * @param int $itemsPerPage
     * @param string $orderColumn
     * @param string $orderDirection
     * @return OrganizationRelationPaginator
     */
    public function getOrganizationRelationsPaginator(int $organizationId, int $page, int $itemsPerPage, string $orderColumn, string $orderDirection)
    {
        /** @var OrganizationRepository $repository */
        $repository = $this->entityManager->getRepository(Organization::class);

        $query = $repository->getOrganizationRelationsQuery($organizationId);

        if ($page < 1) {
            $page = 1;
        }

        if ($itemsPerPage < 1 || $itemsPerPage > $this->maxResults) {
            $itemsPerPage = $this->maxResults;
        }

        $firstResult = ($page - 1) * $itemsPerPage;

        $orderBy = $orderColumn . ' ' . $orderDirection;

        return new OrganizationRelationPaginator($query, $firstResult, $itemsPerPage, $orderBy);
    }
}
