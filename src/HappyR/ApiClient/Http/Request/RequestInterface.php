<?php


namespace HappyR\ApiClient\Http\Request;

/**
 * This is an iterface for the HTTP Request
 *
 */
interface RequestInterface
{

    /**
     * Set a option
     *
     * @param mixed $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setOption($name, $value);

    /**
     * Execute the request
     *
     *
     * @return mixed response
     */
    public function execute();

    /**
     * Get info
     *
     * @param mixed $name
     *
     * @return mixed
     */
    public function getInfo($name);

    /**
     * Close the request
     *
     *
     * @return mixed
     */
    public function close();
}