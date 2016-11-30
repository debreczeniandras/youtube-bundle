<?php

namespace Dga\YoutubeBundle\DependencyInjection;

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
        $rootNode    = $treeBuilder->root('dga_youtube');

        $rootNode
            ->children()
            ->scalarNode('base_url')->isRequired()->defaultValue('https://www.googleapis.com/youtube/v3/')->end()
            ->scalarNode('token_uri')->isRequired()->defaultValue('https://accounts.google.com/o/oauth2/token')->end()
            ->scalarNode('client_id')->isRequired()->end()
            ->scalarNode('refresh_token')->isRequired()->end()
            ->scalarNode('client_secret')->isRequired()->end()
            ->scalarNode('channel_id')->defaultNull()->end()
            ->arrayNode('additional_params')->defaultNull()->end()

            ->end();

        return $treeBuilder;
    }
}
