<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

class Country
{
	/**
	 * @JMS\Type("string")
	 */
	public $name;
	
}