<?php

declare(strict_types=1);

namespace Zoglo\ContaoUserInterfaceBackport;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zoglo\ContaoUserInterfaceBackport\DependencyInjection\Compiler\AddAssetsPackagesPass;

class ContaoUserInterfaceBackport extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AddAssetsPackagesPass());
    }
}
