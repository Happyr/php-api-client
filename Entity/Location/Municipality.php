<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

class Municipality
{
	/**
	 * @JMS\Type("string")
	 */
	public $name;
	
	/**
	 * @JMS\Type("string")
	 */
	public $code;
	
}