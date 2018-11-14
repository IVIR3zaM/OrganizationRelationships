<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Entity;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity as SoftDeleteable;
use Gedmo\Timestampable\Traits\TimestampableEntity as Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Entity
 * @codeCoverageIgnore
 * @ORM\Table(
 *     name="organization",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="organization_name_idx", columns={"name"})
 *     }
 * )
 * @ORM\Entity(
 *     repositoryClass="IVIR3zaM\OrganizationRelationships\AppBundle\Entity\OrganizationRepository"
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Organization
{
    use Timestampable,
        SoftDeleteable;

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var OrganizationRelation[]
     * @ORM\OneToMany(targetEntity="OrganizationRelation", mappedBy="parentRelations", cascade="persist")
     */
    private $parentRelations;

    /**
     * @var OrganizationRelation[]
     * @ORM\OneToMany(targetEntity="OrganizationRelation", mappedBy="childRelations", cascade="persist")
     */
    private $childRelations;

    public function __construct() {
        $this->parentRelations = new ArrayCollection();
        $this->childRelations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = strval($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getParentRelations()
    {
        return $this->parentRelations;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildRelations()
    {
        return $this->childRelations;
    }
}
