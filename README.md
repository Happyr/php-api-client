Happyr PHP API client
=====================

[![Latest Version](https://img.shields.io/github/release/Happyr/php-api-client.svg?style=flat-square)](https://github.com/Happyr/php-api-client/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/Happyr/php-api-client.svg?style=flat-square)](https://travis-ci.org/Happyr/php-api-client)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Happyr/php-api-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/php-api-client)
[![Quality Score](https://img.shields.io/scrutinizer/g/Happyr/php-api-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/php-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/happyr/api-php-client.svg?style=flat-square)](https://packagist.org/packages/happyr/api-php-client)

This PHP library is a client to the API at [api.happyr.com][1].


Installation
------------

```bash
composer require happyr/api-php-client
```

Configuration
-------------

There is a few mandatory configuration parameters. They are 'identifier' and 'secret'. You will get them both
from the [Happyr-API website][1]. 

Usage
-----
```php
use Happyr\ApiClient\HappyrClient;

class MyClass
{
    public function myFunc()
    {
        $api = HappyrClient::create('myApiIdentifier', 'myApiSecret');
        $patterns = $api->profilePattern()->index('sv');
    }
}
```


[1]: https://api.happyr.com

