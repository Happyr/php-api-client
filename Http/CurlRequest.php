<?php


namespace Happyr\ApiClient\Http;


/**
 * Class CurlRequest
 *
 * This is a wrapper for curl
 */
class CurlRequest implements HttpRequestInterface
{
    private $handle = null;

    /**
     * Construct the
     *
     * @param string|null $url
     */
    public function __construct($url=null) {
        $this->handle = curl_init($url);
    }

    /**
     * Set option
     *
     * @param mixed $name
     * @param mixed $value
     *
     */
    public function setOption($name, $value) {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * Execute the curl !
     *
     *
     * @return mixed
     */
    public function execute() {
        return curl_exec($this->handle);
    }

    /**
     * Get some info
     *
     * @param mixed $name
     *
     * @return mixed
     */
    public function getInfo($name) {
        return curl_getinfo($this->handle, $name);
    }

    /**
     * Close the connection
     */
    public function close() {
        curl_close($this->handle);
    }

}