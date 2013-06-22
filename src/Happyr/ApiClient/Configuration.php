<?php

namespace Happyr\ApiClient;


class Configuration
{
    public $username='';//your username here
    public $token=''; //Your api token goes here
    public $baseUrl='http://happyrecruiting.se/api/'; //must end with a slash (/)
    public $version='1.0';
    public $format='xml'; //You should have a good reason not to choose xml.

    public $enableExceptions=false;//if true, we will throw exceptions on error
    public $debug=false; //enables debug mode

    /**
     * @param null $username
     * @param null $token
     */
    public function __construct($username=null,$token=null)
    {
        if($token!=null){
            $this->token=$token;
        }

        if($username!=null){
            $this->username=$username;
        }
    }


}
