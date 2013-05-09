<?php

namespace Happyr\ApiClient\Entity\Populus;

use JMS\Serializer\Annotation as JMS;

class Question
{
	/**
	 * @JMS\Type("integer")
	 */
	public $id;
	
	/**
	 * @JMS\Type("string")
	 */
	public $question;
	
	/**
	 * @JMS\Type("array<Happyr\ApiClient\Entity\Populus\Answer>")
	 */
	public $answers;
}
