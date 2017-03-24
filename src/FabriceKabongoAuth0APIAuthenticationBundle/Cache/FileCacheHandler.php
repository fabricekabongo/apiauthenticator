<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 2017/03/24
 * Time: 10:11 PM
 */

namespace FabriceKabongo\Auth0\APIAuthenticationBundle\Cache;


use Auth0\SDK\Helpers\Cache\FileSystemCacheHandler;

class FileCacheHandler extends FileSystemCacheHandler
{
    public function __construct($tempDirectory, $mode = 0777, $recursive = true)
    {
        if (!is_dir($tempDirectory)) {
            if (!mkdir($tempDirectory, $mode, $recursive)) {
                throw new \Exception("Failed to create the clients cache directory.");
            }
        }

        $this->tmp_dir = $tempDirectory;
    }
}