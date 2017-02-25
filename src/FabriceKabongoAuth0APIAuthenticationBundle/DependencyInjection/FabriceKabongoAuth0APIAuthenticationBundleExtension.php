<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/02/25
 * Time: 2:40 AM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\DependencyInjection;

use FabriceKabongo\Auth0\APIAuthenticationBundle\Security\ApiKeyAuthenticator;
use FabriceKabongo\Auth0\APIAuthenticationBundle\Security\ApiKeyUserProvider;
use FabriceKabongo\Auth0\APIAuthenticationBundle\Security\ApiUser;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;


class FabriceKabongoAuth0APIAuthenticationBundleExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter(
            'fabricekabongo.auth0.apiauthentication.valid_audiences',
            $mergedConfig['valid_audiences']
        );
        $container->setParameter(
            'fabricekabongo.auth0.apiauthentication.authorized_iss',
            $mergedConfig['authorized_iss']
        );


        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->addClassesToCompile(array(
            ApiKeyUserProvider::class,
            ApiUser::class,
            ApiKeyAuthenticator::class
        ));
    }

}