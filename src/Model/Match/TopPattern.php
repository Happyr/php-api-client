<?php

namespace Happyr\ApiClient\Model\Match;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class TopPattern implements CreatableFromArray
{
    /**
     * @var array
     */
    private $patterns;

    /**
     * @param array $patterns
     */
    private function __construct(array $patterns)
    {
        $this->patterns = $patterns;
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
    public function getPatterns()
    {
        return $this->patterns;
    }
}
