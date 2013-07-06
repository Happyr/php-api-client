<?php

namespace Happyr\ApiClient\Entity\Populus;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Answer
 *
 * This class represents an answer to the test
 */
class Answer
{
    /**
     * @JMS\Type("integer")
     */
    public $id;

    /**
     * @JMS\Type("string")
     */
    public $label;


}
