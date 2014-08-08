<?php

namespace HappyR\ApiClient;

/**
 * Class Configuration
 *
 * This is the configuration of the client
 */
class Configuration
{
    //your api identifier
    public $identifier='';

    //Your api secret
    public $secret='';

    //must not end with a slash (/)
    public $baseUrl='http://api.happyr.com';

    //You should have a good reason not to choose xml.
    public $format='xml';

    /**
     * @var string
     *
     * the class to use when making a http request. The class must implement
     * the HappyR\ApiClient\Http\HttpRequestInterface
     */
    public $httpRequestClass='\HappyR\ApiClient\Http\Request\Guzzle';

    //if true, we will throw exceptions on error
    public $enableExceptions=false;

    //enables debug mode
    public $debug=false;

    //The version of this client. This is for our statistics only
    public $clientVersion=2.0;

    /**
     * @param string $identifier
     * @param string $secret
     */
    public function __construct($identifier=null, $secret=null)
    {
        if ($secret!=null) {
            $this->secret=$secret;
        }

        if ($identifier!=null) {
            $this->identifier=$identifier;
        }
    }
}