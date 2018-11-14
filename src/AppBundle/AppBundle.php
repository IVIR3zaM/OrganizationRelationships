<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle;

use IVIR3zaM\OrganizationRelationships\AppBundle\DependencyInjection\OverrideFosRestExceptionNormalizerCompilerPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Config\FileLocator;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle
 * @codeCoverageIgnore
 */
class AppBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->loadServiceConfig($container);
        $this->addDoctrineAnnotationLoader($container);

        $container->addCompilerPass(new OverrideFosRestExceptionNormalizerCompilerPass());
    }
    /**
     * @param ContainerBuilder $container
     */
    private function loadServiceConfig(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/Resources/config')
        );

        $loader->load('services.yml');
        $loader->load('normalizer.yml');
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addDoctrineAnnotationLoader(ContainerBuilder $container)
    {
        $namespaces = ['IVIR3zaM\OrganizationRelationships\AppBundle\Entity'];
        $directories = [__DIR__ . '/Entity'];
        $container->addCompilerPass(DoctrineOrmMappingsPass::createAnnotationMappingDriver($namespaces, $directories));
    }
}
