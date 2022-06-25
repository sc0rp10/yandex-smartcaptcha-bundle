<?php declare(strict_types=1);

namespace Sc\YandexSmartCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('yandex_smartcaptcha');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('secret_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('site_key')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
