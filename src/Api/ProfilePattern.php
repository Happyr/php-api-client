<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Model\ProfilePattern\Created;
use Happyr\ApiClient\Model\ProfilePattern\Index;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ProfilePattern extends HttpApi
{
    /**
     * @param string $lang
     *
     * @return Index|ResponseInterface
     */
    public function index($lang)
    {
        Assert::stringNotEmpty($lang);

        $response = $this->httpGet('/api/patterns', ['lang' => $lang]);

        return $this->hydrateResponse($response, Index::class);
    }

    /**
     * @param array $dimensions
     * @param $lang
     *
     * @return Created|ResponseInterface
     */
    public function create(array $dimensions, $lang)
    {
        Assert::notEmpty($dimensions);
        Assert::stringNotEmpty($lang);

        $response = $this->httpPost('/api/patterns/create', ['dimensions' => $dimensions, 'lang' => $lang]);

        return $this->hydrateResponse($response, Created::class);
    }
}
