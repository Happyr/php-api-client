<?php

namespace Happyr\ApiClient\Model\UserManagement;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class User implements CreatableFromArray
{
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
