<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Exception;
use Happyr\ApiClient\Model\Dimension\Index;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Dimension extends HttpApi
{
    /**
     * @param string $username
     * @param array  $params
     *
     * @return Index|ResponseInterface
     *
     * @throws Exception
     */
    public function index($lang)
    {
        Assert::stringNotEmpty($lang);

        $response = $this->httpGet('/api/dimensions', ['lang' => $lang]);

        return $this->hydrateResponse($response, Index::class);
    }
}
