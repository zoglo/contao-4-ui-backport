<?php

declare(strict_types=1);

namespace Zoglo\ContaoUserInterfaceBackport\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Zoglo\ContaoUserInterfaceBackport\ContaoUserInterfaceBackport;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoUserInterfaceBackport::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class
                ])
                ->setReplace(['contao-ui-backport']),
        ];
    }

    /**
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        $loader->load('@ContaoUserInterfaceBackport/config/config.yaml');
    }
}
