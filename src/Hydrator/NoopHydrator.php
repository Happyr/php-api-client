<?php

namespace Happyr\ApiClient\Hydrator;

use Psr\Http\Message\ResponseInterface;

/**
 * Do not hydrate to any object at all.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class NoopHydrator implements Hydrator
{
    /**
     * @param ResponseInterface $response
     * @param string            $class
     *
     * @throws \LogicException
     */
    public function hydrate(ResponseInterface $response, $class)
    {
        throw new \LogicException('The Noop Hydrator should never be called');
    }
}
