<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/02/24
 * Time: 4:41 PM
 */

namespace FabriceKabongo\Auth0\Symfony\API;

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
            $user = new ApiUser($username, null, []);
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