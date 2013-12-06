<?php


namespace HappyR\ApiClient\Http\Request;

/**
 * Class CurlRequest
 *
 * This is a wrapper for curl
 */
class CurlRequest implements RequestInterface
{
    private $handle = null;

    /**
     * Construct the curl
     *
     */
    public function __construct()
    {
        $this->handle=curl_init();
    }

    /**
     * Set option
     *
     * @param mixed $name
     * @param mixed $value
     *
     *
     * @return $this
     */
    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);

        return $this;
    }

    /**
     * Execute the curl !
     *
     *
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->handle);
    }

    /**
     * Get some info
     *
     * @param mixed $name
     *
     * @return mixed
     */
    public function getInfo($name)
    {
        return curl_getinfo($this->handle, $name);
    }

    /**
     * Close the connection
     */
    public function close()
    {
        curl_close($this->handle);
    }
}