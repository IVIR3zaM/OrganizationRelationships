<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Normalizer;

use IVIR3zaM\OrganizationRelationships\AppBundle\Response\SuccessState;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Normalizer
 * @codeCoverageIgnore
 */
class SuccessStateNormalizer implements NormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var SuccessState $object */
        return [
            'data' => [
                'success' => $object->isSuccess()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof SuccessState;
    }
}
