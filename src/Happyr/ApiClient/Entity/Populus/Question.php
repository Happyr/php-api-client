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
	
	/**
	 * @JMS\Type("integer")
	 * 
	 * the progress is a value between 0 and 100 that tells how the 
	 * questionare progress is developing. You may use this in a progressbar. 
	 */
	public $progress;
}
