<?php

namespace Happyr\ApiClient\Model\Dimension;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Index implements CreatableFromArray
{
    /**
     * @var array with keys id, language and name
     */
    private $dimensions;

    /**
     * @param array $dimensions
     */
    private function __construct(array $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        return new self($data['data']);
    }

    /**
     * @return array
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }
}
