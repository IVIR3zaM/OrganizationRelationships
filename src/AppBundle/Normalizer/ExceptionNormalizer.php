<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Normalizer;

use FOS\RestBundle\Serializer\Normalizer\ExceptionNormalizer as FosRestExceptionNormalizer;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Normalizer
 * @codeCoverageIgnore
 */
class ExceptionNormalizer extends FosRestExceptionNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $message = $this->getExceptionMessage(
            $object,
            isset($context['template_data']['status_code']) ? $context['template_data']['status_code'] : null
        );

        return [
            'data' => [
                'errors' => [
                    'generic' => $message
                ]
            ]
        ];
    }
}
