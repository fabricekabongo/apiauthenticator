<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/03/04
 * Time: 6:16 PM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\Test;

use FabriceKabongo\Auth0\APIAuthenticationBundle\Security\ApiUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class AuthenticatedWebTestCase extends WebTestCase
{
    /**
     * @param Client $client
     * @param array $roles
     * @return Client
     */
    protected function setUpClient(Client $client, array $roles  = array())
    {
        $user = new ApiUser("just-a-dummy-token", array_merge([
            "ROLE_USER"
        ], $roles));

        $stub = $this->getMockBuilder('FabriceKabongo\Auth0\APIAuthenticationBundle\Security\ApiKeyUserProvider')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $stub->method('loadUserByUsername')
            ->willReturn($user);
        $stub->method('supportsClass')
            ->willReturn(null);

            static::$kernel->getContainer()->set('fabricekabongo.auth0.services.apikeyuserprovider', $stub);

        return $client;
    }
}