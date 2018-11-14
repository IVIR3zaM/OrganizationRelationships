<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Normalizer;

use IVIR3zaM\OrganizationRelationships\AppBundle\Exception\ValidationFailedBadRequestHttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Psr\Log\LoggerInterface;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Normalizer
 */
class ValidationFailedBadRequestHttpExceptionNormalizer implements NormalizerInterface
{
    /**
     * Error pass for errors with empty property path
     */
    const GENERIC_PROPERTY_PATH = 'generic';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ValidationFailedBadRequestHttpExceptionNormalizer constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function normalize($object, $format = null, array $context = array())
    {
        /** @var ValidationFailedBadRequestHttpException $object */
        $validationErrors = $this->convertViolationListToErrorsArray($object->getConstraintViolationList());

        $this->logger->warning('Api validation failed', ['errors' => $validationErrors]);
        return [
            'data' =>[
                'errors' => $validationErrors
            ]
        ];
    }
    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ValidationFailedBadRequestHttpException;
    }

    /**
     * @param ConstraintViolationListInterface $violationList
     * @return array
     */
    private function convertViolationListToErrorsArray(ConstraintViolationListInterface $violationList)
    {
        $result = [];
        /** @var ConstraintViolation $item */
        foreach ($violationList as $item) {
            $path = $item->getPropertyPath();

            if (strlen($path) === 0) {
                $path = self::GENERIC_PROPERTY_PATH;
            }

            if ($path === self::GENERIC_PROPERTY_PATH && isset($result[$path])) {
                $result[$path] .= '|' . $item->getMessage();
            } else {
                $result[$path] = $item->getMessage();
            }
        }
        return $result;
    }
}
