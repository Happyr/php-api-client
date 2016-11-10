<?php

namespace Happyr\ApiClient\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Happyr\ApiClient\Http\Response\Response;

/**
 * Class Guzzle
 *
 * @author Tobias Nyholm
 */
class Guzzle implements RequestInterface
{
    /**
     *
     *
     * @param $url
     * @param array $data
     * @param string $httpVerb
     * @param array $headers
     *
     * @return \Happyr\ApiClient\Http\Response\Response
     */
    public function send($url, array $data = array(), $httpVerb = 'GET', array $headers = array())
    {
        $options=array(
            'headers'=>$headers,
            'timeout' => 60,
            'exceptions' => false,
        );

        $client = new Client();
        if ($httpVerb=='GET' && count($data)>0) {
            $url.='?'.http_build_query($data);
        } else {
            $options['body']=$data;
        }

        $request=$client->createRequest($httpVerb, $url, $options);
        try {
            $res=$client->send($request);
            $response=new Response($res->getBody(), $res->getStatusCode());
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response=new Response($res->getBody(), $res->getStatusCode());
            } else {
                throw $e;
            }
        }

        return $response;
    }
}