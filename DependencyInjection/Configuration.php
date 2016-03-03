<?php

namespace SmartInformationSystems\EmailBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('smart_information_systems_email');

        $rootNode->children()
            ->scalarNode('from_email')->end()
            ->scalarNode('from_name')->end()
            ->scalarNode('reply_to')->defaultValue('')->end()
            ->scalarNode('images_as_attachments')->defaultValue(FALSE)->end();

        return $treeBuilder;
    }
}
