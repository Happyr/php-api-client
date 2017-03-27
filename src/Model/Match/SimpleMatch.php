<?php

namespace Happyr\ApiClient\Model\Match;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class SimpleMatch implements CreatableFromArray
{
    /**
     * @var array
     */
    private $matches;

    /**
     * @param array $matches
     */
    private function __construct(array $matches)
    {
        $this->matches = $matches;
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
    public function getMatches()
    {
        return $this->matches;
    }
}
