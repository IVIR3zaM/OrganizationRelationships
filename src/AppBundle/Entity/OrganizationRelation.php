<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Entity;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity as SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity as Timestampable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Entity
 * @codeCoverageIgnore
 * @ORM\Table(
 *     name="organization_relation",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="organization_relation_idx", columns={
 *             "parent_organization_id", "child_organization_id"
 *         })
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRelationRepository"
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class OrganizationRelation
{
    use Timestampable,
        SoftDeleteable;

    /**
     * @var string
     */
    const PARENT_TYPE = 'parent';

    /**
     * @var string
     */
    const DAUGHTER_TYPE = 'daughter';

    /**
     * @var string
     */
    const SISTER_TYPE = 'sister';

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="parent_organization_id", type="integer", length=11, nullable=true)
     */
    private $parentOrganizationId;

    /**
     * @var Organization
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="parentRelations", cascade="persist")
     * @ORM\JoinColumn(name="parent_organization_id", referencedColumnName="id")
     */
    private $parentOrganization;

    /**
     * @var int
     * @ORM\Column(name="child_organization_id", type="integer", length=11, nullable=true)
     */
    private $childOrganizationId;

    /**
     * @var Organization
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="childRelations", cascade="persist")
     * @ORM\JoinColumn(name="child_organization_id", referencedColumnName="id")
     */
    private $childOrganization;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $organizationId
     * @return static
     */
    public function setParentOrganizationId($organizationId)
    {
        $this->parentOrganizationId = intval($organizationId);

        return $this;
    }

    /**
     * @return int
     */
    public function getParentOrganizationId()
    {
        return $this->parentOrganizationId;
    }

    /**
     * @param int $organizationId
     * @return static
     */
    public function setChildOrganizationId($organizationId)
    {
        $this->childOrganizationId = intval($organizationId);

        return $this;
    }

    /**
     * @return int
     */
    public function getChildOrganizationId()
    {
        return $this->childOrganizationId;
    }

    /**
     * @param Organization $organization
     * @return static
     */
    public function setParentOrganization(Organization $organization)
    {
        $this->parentOrganization = $organization;

        return $this;
    }

    /**
     * @return Organization
     */
    public function getParentOrganization()
    {
        return $this->parentOrganization;
    }

    /**
     * @param Organization $organization
     * @return static
     */
    public function setChildOrganization(Organization $organization)
    {
        $this->childOrganization = $organization;

        return $this;
    }

    /**
     * @return Organization
     */
    public function getChildOrganization()
    {
        return $this->childOrganization;
    }
}
