<?php

namespace HappyR\ApiClient\Entity\Potential;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Score
 *
 * This class represents the score on the matching
 */
class Match
{
    /**
     * @JMS\Type("integer")
     */
    public $score;

    /**
     * @var bool complete
     *
     * Is the match score complete or does the user have more questions to answer
     *
     * @JMS\Type("boolean")
     */
    public $complete;
}
