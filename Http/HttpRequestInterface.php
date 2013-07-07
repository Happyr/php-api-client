<?php


namespace Happyr\ApiClient\Http;


/**
 * This is an iterface for the HTTP Request
 * 
 */
interface HttpRequestInterface 
{
    public function createNew();
    public function setOption($name, $value);
    public function execute();
    public function getInfo($name);
    public function close();
}