<?php


namespace HappyR\ApiClient\Tests\Live;

use HappyR\ApiClient\Configuration;
use HappyR\ApiClient\HappyRApi;

/**
 * Class LiveApiClient
 *
 * @author Tobias Nyholm
 *
 */
class LiveApiClient
{
    /**
     * Get a new HappyRApi with the configuration in the parameter.ini file
     *
     *
     * @return HappyRApi
     * @throws \RuntimeException
     */
    static function get()
    {
        $paramfile = file_get_contents(__DIR__ . '/parameters.ini');
        if ($paramfile === false) {
            throw new \RuntimeException('There is no paramters.ini file');
        }

        $params = explode("\n", $paramfile);
        $conf = new Configuration();
        foreach ($params as $param) {
            if (!strstr($param, '=')) {
                continue;
            }
            list($name, $value) = explode('=', $param);
            $conf->$name = $value;
        }

        return new HappyRApi($conf);
    }
}