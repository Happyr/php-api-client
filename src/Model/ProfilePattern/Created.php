<?php

namespace Happyr\ApiClient\Model\ProfilePattern;

use Happyr\ApiClient\Model\CreatableFromArray;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Created implements CreatableFromArray
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $language;

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $language
     */
    public function __construct($id, $name, $description, $language)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->language = $language;
    }

    /**
     * @param array $data
     *
     * @return
     */
    public static function createFromArray(array $data)
    {
        $data = $data['data'];

        return new self($data['id'], $data['name'], $data['description'], $data['language']);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
