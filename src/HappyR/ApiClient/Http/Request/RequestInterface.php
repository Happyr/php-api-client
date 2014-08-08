<?php


namespace Happyr\ApiClient\Http\Request;

/**
 * This is an interface for the HTTP Request
 *
 */
interface RequestInterface
{
    /**
     *
     *
     * @param $uri
     * @param array $data
     * @param string $httpVerb
     * @param array $headers
     *
     * @return \Happyr\ApiClient\Http\Response\Response
     */
    public function send($uri, array $data=array(), $httpVerb='GET', array $headers=array());

}