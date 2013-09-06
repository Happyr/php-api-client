<?php

namespace HappyR\ApiClient\Entity\Potential;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Statement
 *
 * This class represents a statement in the test
 */
class Statement
{
    /**
     * @JMS\Type("integer")
     */
    public $id;

    /**
     * @JMS\Type("string")
     */
    public $sentence;

    /**
     * @JMS\Type("array<HappyR\ApiClient\Entity\Potential\Answer>")
     * @JMS\SerializedName("assessments")
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
