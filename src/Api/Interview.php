<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Model\Dimension\Interview as InterviewModel;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Interview extends HttpApi
{
    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are norm and locale
     *
     * @return InterviewModel|ResponseInterface
     */
    public function show($user, array $patterns, array $params)
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/interview/guide', $params);

        return $this->hydrateResponse($response, InterviewModel::class);
    }
}
