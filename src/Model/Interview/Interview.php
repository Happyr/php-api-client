<?php

namespace Happyr\ApiClient\Model\Interview;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Interview implements CreatableFromArray
{
    /**
     * @var array with keys as profile ids and each profile has a name, statements and questions
     */
    private $profiles;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $complete;

    /**
     * @param array  $profiles
     * @param string $description
     * @param bool   $complete
     */
    private function __construct(array $profiles, $description, $complete)
    {
        $this->profiles = $profiles;
        $this->description = $description;
        $this->complete = $complete;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        return new self($data['data']['profiles'], $data['data']['description'], $data['data']['complete']);
    }

    /**
     * This is allow legacy code use the interview object.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'profiles' => $this->profiles,
            'description' => $this->description,
            'complete' => $this->complete,
        ];
    }

    /**
     * @return array
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isComplete()
    {
        return $this->complete;
    }
}
