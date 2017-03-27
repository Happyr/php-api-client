<?php

namespace Happyr\ApiClient\Http\Request;

use Happyr\ApiClient\Http\Response\Response;

/**
 * Class CurlRequest.
 *
 * This is a wrapper for curl
 */
class CurlRequest implements RequestInterface
{
    /**
     * @param $uri
     * @param array  $data
     * @param string $httpVerb
     * @param array  $headers
     *
     * @return mixed
     */
    public function send($uri, array $data = array(), $httpVerb = 'GET', array $headers = array())
    {
        $ch = curl_init();

        $headers = $this->rewriteHeaders($headers);

        // Set a referrer and user agent
        if (isset($_SERVER['HTTP_HOST'])) {
            curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        }

        //do not include the http header in the result
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //return the data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        //follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        //add headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        switch ($httpVerb) {
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            case 'POST':
                $this->preparePostData($ch, $data);
                curl_setopt($ch, CURLOPT_URL, $this->buildUrl($uri));
                break;
            case 'GET':
                curl_setopt($ch, CURLOPT_URL, $this->buildUrl($uri, $data));
                break;
            default:
                throw new \InvalidArgumentException('HTTP method must be either "GET", "POST" or "DELETE"');
        }

        //execute request
        $body = curl_exec($ch);

        //get the http status code
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //close connection
        curl_close($ch);

        $response = new Response($body, $httpStatus);

        return $response;
    }

    /**
     * Build the url with baseUrl and uri.
     *
     * @param string $uri
     * @param array  $filters
     *
     * @return string
     */
    protected function buildUrl($uri, array $filters = array())
    {
        $filterString = '';

        //add the filter on the filter string
        if (count($filters) > 0) {
            $filterString = '?'.http_build_query($filters);
        }

        return $uri.$filterString;
    }

    /**
     * Load the curl object with the post data.
     *
     *
     * @param $ch
     * @param array $data
     */
    protected function preparePostData($ch, array $data = array())
    {
        //urlify the data for the POST
        $dataString = http_build_query($data);

        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    }

    /**
     * Make sure the key of the array is moved to the value.
     *
     * @param array $headers
     *
     * @return array
     */
    protected function rewriteHeaders(array $headers)
    {
        $betterHeaders = array();
        foreach ($headers as $key => $value) {
            $betterHeaders[] = sprintf('%s: %s', $key, $value);
        }

        return $betterHeaders;
    }
}
