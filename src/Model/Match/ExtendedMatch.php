<?php

namespace Happyr\ApiClient\Model\Match;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ExtendedMatch implements CreatableFromArray
{
    /**
     * @var array
     */
    private $profiles;

    /**
     * @var bool
     */
    private $complete;

    /**
     * @param array $profiles
     * @param bool  $complete
     */
    private function __construct(array $profiles, $complete)
    {
        $this->profiles = $profiles;
        $this->complete = $complete;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        return new self($data['data']['profiles'], $data['data']['complete']);
    }

    /**
     * @return array
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return bool
     */
    public function isComplete()
    {
        return $this->complete;
    }
}
