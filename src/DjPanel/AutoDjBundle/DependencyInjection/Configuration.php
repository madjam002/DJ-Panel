<?php

namespace DjPanel\AutoDjBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('auto_dj');

        $rootNode
            ->children()
                ->booleanNode("enabled")
                    ->defaultTrue()
                ->end()
                ->scalarNode("name")
                    ->defaultValue("Auto DJ")
                ->end()
            ->end()
        ;

        /*
         * $rootNode
    ->children()
        ->booleanNode('auto_connect')
            ->defaultTrue()
        ->end()
        ->scalarNode('default_connection')
            ->defaultValue('default')
        ->end()
    ->end()
;
         */

        return $treeBuilder;
    }
}
