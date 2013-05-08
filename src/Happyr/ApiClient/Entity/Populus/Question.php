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
	private $question;
	
	/**
	 * @JMS\Type("array<Happyr\ApiClient\Entity\Populus\Answer>")
	 */
	public $answers;
}
