<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\DependencyInjection;

use IVIR3zaM\OrganizationRelationships\AppBundle\Normalizer\ExceptionNormalizer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\DependencyInjection
 * @codeCoverageIgnore
 */
class OverrideFosRestExceptionNormalizerCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('fos_rest.serializer.exception_normalizer.symfony');
        $definition->setClass(ExceptionNormalizer::class);
    }
}
