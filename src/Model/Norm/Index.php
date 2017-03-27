<?php

namespace Happyr\ApiClient\Model\Norm;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Index implements CreatableFromArray
{
    /**
     * @var array
     */
    private $norms;

    /**
     * @param array $norms
     */
    private function __construct(array $norms)
    {
        $this->norms = $norms;
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
    public function getNorms()
    {
        return $this->norms;
    }
}
