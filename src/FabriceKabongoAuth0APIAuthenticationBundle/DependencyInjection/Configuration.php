<?php

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fk_auth0_api');

        $rootNode
            ->children()
                    ->arrayNode('valid_audiences')->end()
                    ->arrayNode('authorized_iss')->end()
                ->end()// twitter
            ->end();

        return $treeBuilder;
    }
}