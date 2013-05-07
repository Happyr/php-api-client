<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

class ZipCode
{
	/**
	 * @JMS\Type("string")
	 */
	public $name;
	
}