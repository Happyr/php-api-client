<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Model\Statement\Statement as StatementModel;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Statement extends HttpApi
{
    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are limit and locale
     *
     * @return StatementModel|ResponseInterface
     */
    public function next($user, array $patterns, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/pattern/next-statement', $params);

        return $this->hydrateResponse($response, StatementModel::class);
    }

    /**
     * @param $user
     * @param array $patterns
     * @param $statement
     * @param $answer
     * @param array $params valid keys are locale
     *
     * @return StatementModel|ResponseInterface
     */
    public function answer($user, array $patterns, $statement, $answer, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);
        $params['answer'] = $answer;

        $response = $this->httpPost(sprintf('/api/statement/%s', $statement), $params);

        return $this->hydrateResponse($response, StatementModel::class);
    }
}
