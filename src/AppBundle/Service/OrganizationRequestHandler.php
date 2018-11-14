<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Service;

use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRelation;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRepository;
use IVIR3zaM\OrganizationRelationships\AppBundle\Request\OrganizationModel;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Service
 */
class OrganizationRequestHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Organization[]
     */
    private $entityStack;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(OrganizationModel $model)
    {
        $this->entityStack = [];

        $organization = $this->convertRequestModelToEntity($model);

        $this->entityManager->persist($organization);
        $this->entityManager->flush();
    }

    /**
     * @param OrganizationModel $model
     * @return Organization
     */
    private function convertRequestModelToEntity(OrganizationModel $model)
    {
        $organization = $this->getOrganizationEntity($model->getOrgName());

        /** @var OrganizationModel $child */
        foreach ($model->getDaughters() as $child) {
            $daughter = $this->convertRequestModelToEntity($child);

            $parentRelation = new OrganizationRelation();
            $parentRelation->setParentOrganization($organization);
            $parentRelation->setChildOrganization($daughter);

            $organization->getParentRelations()->add($parentRelation);
        }


        return $organization;
    }

    /**
     * @param string $organizationName
     * @return Organization
     */
    private function getOrganizationEntity(string $organizationName)
    {
        $name = trim($organizationName);

        $hash = md5($name);

        if (!isset($this->entityStack[$hash])) {
            /** @var OrganizationRepository $repository */
            $repository = $this->entityManager->getRepository(Organization::class);

            $organization = $repository->findOneBy([
                'name' => $name
            ]);

            if (is_null($organization)) {
                $organization = new Organization();

                $organization->setName($name);
            }

            $this->entityStack[$hash] = $organization;
        }


        return $this->entityStack[$hash];
    }
}
