<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Model\Match\ExtendedMatch;
use Happyr\ApiClient\Model\Match\SelfDescription;
use Happyr\ApiClient\Model\Match\SimpleMatch;
use Happyr\ApiClient\Model\Match\TopPattern;
use Happyr\ApiClient\Model\Match\TopUser;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Match extends HttpApi
{
    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are norm and recalculate
     *
     * @return SimpleMatch|ResponseInterface
     */
    public function show($user, array $patterns, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/match', $params);

        return $this->hydrateResponse($response, SimpleMatch::class);
    }

    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are norm and locale
     *
     * @return ExtendedMatch|ResponseInterface
     */
    public function showExtended($user, array $patterns, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/match/extended', $params);

        return $this->hydrateResponse($response, ExtendedMatch::class);
    }

    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are norm and locale
     *
     * @return SelfDescription|ResponseInterface
     */
    public function selfDescription($user, array $patterns, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/match/self-description', $params);

        return $this->hydrateResponse($response, SelfDescription::class);
    }

    /**
     * @param $user
     * @param array $patterns
     * @param array $params   valid keys are norm and limit
     *
     * @return TopPattern|ResponseInterface
     */
    public function topPatterns($user, array $patterns, array $params = [])
    {
        Assert::stringNotEmpty($user);
        Assert::notEmpty($patterns);

        $params['user'] = $user;
        $params['pattern'] = implode(',', $patterns);

        $response = $this->httpGet('/api/match/top/patterns', $params);

        return $this->hydrateResponse($response, TopPattern::class);
    }

    /**
     * @param string $pattern
     * @param array  $params  valid keys are limit, offset and norm
     *
     * @return TopUser|ResponseInterface
     */
    public function topUser($pattern, array $params = [])
    {
        Assert::stringNotEmpty($pattern);

        $params['pattern'] = $pattern;

        $response = $this->httpGet('/api/match/top/users', $params);

        return $this->hydrateResponse($response, TopUser::class);
    }
}
