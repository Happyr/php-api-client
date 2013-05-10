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
	 * The number of remaining questions (including this one). If this value is 6. That
	 * means that there is this question and 5 other left to answer. 
	 */
	public $remaininQuestions;
}
