<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/02/24
 * Time: 4:41 PM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\Security;

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
     * @param bool $useCache
     */
    public function __construct($validAudiences, $authorizedISS, $useCache = false)
    {
        $verifierConfig = [
            'valid_audiences' => $validAudiences,
            'authorized_iss' => $authorizedISS,
            'supported_algs' => ['RS256']
        ];

        if ($useCache) {
            $verifierConfig['cache']  = new FileSystemCacheHandler();
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