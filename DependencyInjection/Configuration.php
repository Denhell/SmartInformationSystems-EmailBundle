<?php
namespace SmartInformationSystems\EmailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('smart_information_systems_email');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->scalarNode('from_email')->end()
            ->scalarNode('from_name')->end()
            ->scalarNode('reply_to')->defaultValue('')->end()
            ->scalarNode('images_as_attachments')->defaultValue(FALSE)->end()
            ->arrayNode('test_domains')
                ->prototype('scalar')->end()
                ->defaultValue([
                    '@example.com',
                    '@example.org',
                    '@example.net',
                    '@test.com',
                    '@test.ru',
                ])
            ->end()
        ;

        return $treeBuilder;
    }
}
