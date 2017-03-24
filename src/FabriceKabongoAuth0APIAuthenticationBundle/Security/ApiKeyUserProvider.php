<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/02/24
 * Time: 4:41 PM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\Security;

use Auth0\SDK\Helpers\Cache\CacheHandler;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Auth0\SDK\JWTVerifier;

class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @var \Auth0\SDK\JWTVerifier
     */
    protected $verifier;

    /**
     * ApiKeyUserProvider constructor.
     * @param $validAudiences
     * @param $authorizedISS
     * @param null $cacheHandler
     */
    public function __construct($validAudiences, $authorizedISS, $cacheHandler = null)
    {
        $verifierConfig = [
            'valid_audiences' => $validAudiences,
            'authorized_iss' => $authorizedISS,
            'supported_algs' => ['RS256']
        ];

        if (!is_null($cacheHandler) && $cacheHandler instanceof CacheHandler) {
            $verifierConfig['cache']  = $cacheHandler;
        }

        $this->verifier = new JWTVerifier($verifierConfig);

    }

    public function loadUserByUsername($username)
    {

        try {

            $tokenPayload = $this->verifier->verifyAndDecode($username);
            $roles = explode(' ', $tokenPayload->scope);

            $roles = array_map(function ($item) {
                $role = strtoupper($item);
                $role = str_replace(':', '_', $role);

                return "ROLE_" . $role;
            }, $roles);

            $roles[] = 'ROLE_USER';

            $user = new ApiUser($username, $roles);

            return $user;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return ApiUser::class === $class;
    }
}