<?php

declare(strict_types=1);

namespace Symfony\UX\Html;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\UX\Html\Twig\HtmlTwigExtension;

final class HtmlBundle extends AbstractBundle
{
    /**
     * @param array<string, mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->services()
            ->set('.ux_html.twig_extension', HtmlTwigExtension::class)
            ->tag('twig.extension')
        ;
    }

    public function getPath(): string
    {
        return __DIR__;
    }
}
