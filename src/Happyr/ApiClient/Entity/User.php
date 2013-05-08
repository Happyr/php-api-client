<?php

namespace Happyr\ApiClient\Entity;

use JMS\Serializer\Annotation as JMS;

class User
{
	/**
	 * @JMS\Type("string")
	 * @JMS\SerializedName("user_id")
	 */
	public $id;
	
	
}
