<?php

namespace HappyR\ApiClient\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use HappyR\ApiClient\Http\Response\Response;

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
     * @return \HappyR\ApiClient\Http\Response\Response
     */
    public function send($url, array $data = array(), $httpVerb = 'GET', array $headers = array())
    {
        $client = new Client();
        if ($httpVerb=='GET' && count($data)>0) {
            $url.='?'.http_build_query($data);
        }

        $request=$client->createRequest($httpVerb, $url, array(
                'headers'=>$headers,
                'timeout' => 3,
                'exceptions' => false,
            ));
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