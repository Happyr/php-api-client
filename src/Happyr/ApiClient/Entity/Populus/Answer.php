<?php

namespace Happyr\ApiClient\Entity\Populus;

use JMS\Serializer\Annotation as JMS;

class Answer
{
	/**
	 * @JMS\Type("integer")
	 */
	public $id;
	
	/**
	 * @JMS\Type("string")
	 */
	public $label;
	

}
