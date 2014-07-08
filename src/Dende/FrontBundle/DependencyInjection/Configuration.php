<?php

namespace Dende\FrontBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('front');

        $rootNode
            ->children()
                ->scalarNode("download_link")
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            
                ->scalarNode("github_link")
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            
                ->scalarNode("testing_url")
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            
            ->end()
        ;

        return $treeBuilder;
    }
}
