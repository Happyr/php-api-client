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
     * @JMS\Type("array<HappyR\ApiClient\Entity\Potential\Assessment>")
     */
    public $assessments;

    /**
     * @JMS\Type("integer")
     *
     * the progress is a value between 0 and 100 that tells how the
     * test progress is developing. You may use this in a progressbar.
     */
    public $progress;

    /**
     * @var string postUrl is the url you post the assessment to
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("post_url")
     *
     */
    public $postUrl;

}
