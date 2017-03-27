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
     * @return User|ResponseInterface
     *
     * @throws Exception
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
     * @return User|ResponseInterface
     *
     * @throws Exception
     */
    public function update($user, $param)
    {
        Assert::stringNotEmpty($user);
        $param['user'] = $user;

        $response = $this->httpPost('/api/user/update/profile', $param);

        return $this->hydrateResponse($response, User::class);
    }
}
