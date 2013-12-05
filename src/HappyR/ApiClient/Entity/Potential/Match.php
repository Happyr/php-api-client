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
}
