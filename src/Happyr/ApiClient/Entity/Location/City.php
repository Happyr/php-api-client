<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

class City
{
	/**
	 * @JMS\Type("string")
	 */
	public $name;
	
}