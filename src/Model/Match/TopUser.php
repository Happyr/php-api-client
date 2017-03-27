<?php

namespace Happyr\ApiClient\Model\Dimension;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class TopUser implements CreatableFromArray
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
