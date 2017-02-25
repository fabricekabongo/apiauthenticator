<?php

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fabrice_kabongo_auth0_api_authentication_bundle');

        $rootNode
            ->children()
                ->arrayNode('valid_audiences')
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('authorized_iss')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}