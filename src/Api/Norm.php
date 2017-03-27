<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Model\Norm\Index;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Norm extends HttpApi
{
    /**
     * @return Index|ResponseInterface
     */
    public function index()
    {
        $response = $this->httpGet('/api/norms');

        return $this->hydrateResponse($response, Index::class);
    }
}
