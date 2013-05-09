<?php

namespace Happyr\ApiClient\Entity;

use JMS\Serializer\Annotation as JMS;

class Company
{
	/**
	 * @JMS\Type("integer")
	 */
	public $id;
	
	/**
	 * @JMS\Type("string")
	 */
	public $name;
	
	/**
	 * @JMS\Type("string")
	 */
	public $website;
	
	/**
	 * @JMS\Type("string")
	 */
	public $bio;
	
	/**
	 * @JMS\Type("string")
	 */
	public $image;
	
	

	
	
}
