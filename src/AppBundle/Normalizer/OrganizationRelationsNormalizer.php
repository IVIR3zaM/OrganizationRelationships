<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Normalizer;

use IVIR3zaM\OrganizationRelationships\AppBundle\Response\OrganizationRelationPaginator;
use IVIR3zaM\OrganizationRelationships\AppBundle\Response\OrganizationRelationModel;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Normalizer
 * @codeCoverageIgnore
 */
class OrganizationRelationsNormalizer implements NormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof OrganizationRelationPaginator) {
            throw new InvalidArgumentException('object should be a type of OrganizationRelationPaginator');
        }

        $data = [];

        /** @var OrganizationRelationModel $relation */
        foreach($object as $relation) {
            $data[] = [
                'relationship_type' => $relation->getRelationType(),
                'org_name' => $relation->getOrganizationName(),
            ];
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof OrganizationRelationPaginator;
    }
}
