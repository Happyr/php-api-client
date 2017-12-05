<?php

namespace Happyr\ApiClient\Model\UserManagement;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class User implements CreatableFromArray
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @param string $name
     * @param string $email
     */
    private function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        $data = $data['data'];

        return new self(isset($data['name']) ? $data['name']: '', $data['email']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
