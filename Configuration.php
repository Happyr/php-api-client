<?php

namespace Happyr\ApiClient;


class Configuration
{
	public $token=''; //Your api token goes here
	public $username='';
	public $baseUrl='http://growyn.bra/app_dev.php/api/'; //must end with a slash (/)
	public $version='1.0';
	public $format='json'; //You should have a good reason not to choose xml.

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
