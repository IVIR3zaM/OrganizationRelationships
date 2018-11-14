<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Request;

use IVIR3zaM\OrganizationRelationships\AppBundle\Validator\ObjectArray;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Request
 */
class OrganizationModel
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    private $orgName;

    /**
     * @ObjectArray(class="\IVIR3zaM\OrganizationRelationships\AppBundle\Request\OrganizationModel")
     *
     * @var OrganizationModel[]
     */
    private $daughters = [];

    /**
     * @codeCoverageIgnore
     * @param string $name
     * @return static
     */
    public function setOrgName(string $name)
    {
        $this->orgName = $name;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * @codeCoverageIgnore
     * @param array $daughters
     * @return static
     */
    public function setDaughters(array $daughters)
    {
        foreach($daughters as $item) {
            $daughter = new self();
            $daughter->setOrgName($item['org_name']??($item['orgName']??''));

            if (isset($item['daughters'])) {
                $daughter->setDaughters($item['daughters']);
            }

            $this->daughters[] = $daughter;
        }

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return OrganizationModel[]
     */
    public function getDaughters()
    {
        return $this->daughters;
    }
}
