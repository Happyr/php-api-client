<?php

namespace Happyr\ApiClient\Model\Statement;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Statement implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $sentence;

    /**
     * @var array
     */
    private $assessments;

    /**
     * @var int
     */
    private $progress;

    /**
     * @var string
     */
    private $postUrl;

    /**
     * @var string
     */
    private $fullPostUrl;

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $type;

    private function __construct()
    {
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        return new self();
    }
}
