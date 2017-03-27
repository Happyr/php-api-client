<?php

namespace Happyr\ApiClient;

/**
 * We need to override Webmozart\Assert because we want to throw our own Exception.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Assert extends \Webmozart\Assert\Assert
{
    protected static function reportInvalidArgument($message)
    {
        throw new InvalidArgumentException($message);
    }
}
