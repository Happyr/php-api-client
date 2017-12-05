<?php

namespace Happyr\ApiClient\Api;

use Happyr\ApiClient\Assert;
use Happyr\ApiClient\Exception;
use Happyr\ApiClient\Model\UserManagement\User;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class UserManagement extends HttpApi
{
    /**
     * @param string $user
     *
     * @throws Exception
     *
     * @return User|ResponseInterface
     */
    public function show($user)
    {
        Assert::stringNotEmpty($user);

        $response = $this->httpGet('/api/user/info', ['user' => $user]);

        return $this->hydrateResponse($response, User::class);
    }

    /**
     * @param string $user
     * @param array  $param Valid keys are email, name, gender, birthday, country
     *
     * @throws Exception
     *
     * @return User|ResponseInterface
     */
    public function update($user, $param)
    {
        Assert::stringNotEmpty($user);
        $param['user'] = $user;

        $response = $this->httpPost('/api/user/update/profile', $param);

        return $this->hydrateResponse($response, User::class);
    }
    /**
     * @param string $user the user ID we should merge personality data to.
     * @param string $from the user ID we should merge personality data from.
     *
     * @throws Exception
     *
     * @return User|ResponseInterface
     */
    public function merge($user, $from)
    {
        Assert::stringNotEmpty($user);
        Assert::stringNotEmpty($from);
        $param['user'] = $user;
        $param['from'] = $from;

        $response = $this->httpPost('/api/user/merge', $param);

        return $this->hydrateResponse($response, User::class);
    }
}
