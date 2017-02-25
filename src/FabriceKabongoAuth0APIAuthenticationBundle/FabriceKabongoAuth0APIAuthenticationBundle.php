<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/02/25
 * Time: 2:07 AM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle;


use FabriceKabongo\Auth0\APIAuthenticationBundle\DependencyInjection\FabriceKabongoAuth0APIAuthenticationBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FabriceKabongoAuth0APIAuthenticationBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (is_null($this->extension)) {
            $this->extension = new FabriceKabongoAuth0APIAuthenticationBundleExtension();
        }

        return $this->extension;
    }

}