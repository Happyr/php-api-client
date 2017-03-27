<?php

namespace Happyr\ApiClient\Model\ProfilePattern;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Index implements CreatableFromArray
{
    /**
     * @var array
     */
    private $profilePatterns;

    /**
     * @param array $profilePatterns
     */
    private function __construct(array $profilePatterns)
    {
        $this->profilePatterns = $profilePatterns;
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
    public function getProfilePatterns()
    {
        return $this->profilePatterns;
    }
}
