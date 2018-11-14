<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Response;

use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\Organization;
use IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRelation as Relation;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Response
 */
class OrganizationRelationModel
{
    /**
     * @var string
     */
    private $organizationName;

    /**
     * @var string
     */
    private $relationType;

    /**
     * @param string $organizationName
     * @param string $relationType
     */
    public function __construct(string $organizationName, string $relationType)
    {
        $this->setOrganizationName($organizationName);
        $this->setRelationType($relationType);
    }

    /**
     * @codeCoverageIgnore
     * @param string $name
     * @return static
     */
    public function setOrganizationName(string $name)
    {
        $this->organizationName = $name;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @codeCoverageIgnore
     * @param string $type
     * @return static
     */
    public function setRelationType(string $type)
    {
        $this->relationType = $type;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getRelationType()
    {
        return $this->relationType;
    }
}
