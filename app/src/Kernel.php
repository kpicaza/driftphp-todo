<?php

namespace App;

use Drift\HttpKernel\AsyncKernel;
use Mmoreram\SymfonyBundleDependencies\BundleDependenciesResolver;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends AsyncKernel
{
    use MicroKernelTrait;
    use BundleDependenciesResolver;

    public function registerBundles(): iterable
    {
        return $this->getBundleInstances($this, [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
        ]);
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__ . '/../../');
    }

    /**
     * @return string
     */
    private function getApplicationLayerDir(): string
    {
        return $this->getProjectDir().'/src';
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $confDir = $this->getProjectDir().'/config';
        $container->setParameter('container.dumper.inline_class_loader', true);
        $container->setDefinition(\React\MySQL\ConnectionInterface::class, new Definition(

        ));
        $loader->load($confDir.'/services.yml');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';
        $routes->import($confDir.'/routes.yml');
    }
}
