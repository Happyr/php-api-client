<?php

namespace Happyr\ApiClient\Model\Match;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class TopUser implements CreatableFromArray
{
    /**
     * @var array
     */
    private $users;

    /**
     * @param array $users
     */
    private function __construct(array $users)
    {
        $this->users = $users;
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
    public function getUsers()
    {
        return $this->users;
    }
}
