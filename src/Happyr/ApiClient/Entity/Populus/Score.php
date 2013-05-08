<?php

namespace Happyr\ApiClient\Entity\Populus;


use JMS\Serializer\Annotation as JMS;

class Score
{
	/**
	 * @JMS\Type("integer")
	 */
	public $score;
}
