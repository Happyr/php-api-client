<?php

namespace Happyr\ApiClient\Model\Match;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class SelfDescription implements CreatableFromArray
{
    /**
     * @var array
     */
    private $profiles;

    /**
     * @var array
     */
    private $strongDescription;

    /**
     * @var array
     */
    private $weakDescription;

    /**
     * @param array $profiles
     * @param array $strongDescription
     * @param array $weakDescription
     */
    public function __construct(array $profiles, array $strongDescription, array $weakDescription)
    {
        $this->profiles = $profiles;
        $this->strongDescription = $strongDescription;
        $this->weakDescription = $weakDescription;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        $profiles = isset($data['data']['profiles']) ? $data['data']['profiles'] : [];
        $strong = isset($data['data']['description']['strong']) ? $data['data']['description']['strong'] : [];
        $week = isset($data['data']['description']['weak']) ? $data['data']['description']['weak'] : [];

        return new self($profiles, $strong, $week);
    }

    /**
     * @return array
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return array
     */
    public function getStrongDescription()
    {
        return $this->strongDescription;
    }

    /**
     * @return array
     */
    public function getWeakDescription()
    {
        return $this->weakDescription;
    }
}
