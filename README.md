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

Install it with Composer!

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/api-php-client": "dev-master",
    }
}
```

Then, you can install the new dependencies by running Composer's ``update``
command from the directory where your ``composer.json`` file is located:

```bash
$ php composer.phar update
```

Configuration
-------------

There is a few mandatory configuration parameters. They are 'identifier' and 'secret'. You will get them both
from the [Happyr-API website][1]. You may add those in the Configuration.php or set them in runtime.

You find a the full configuration reference [here][3].

Usage
-----
```php
use Happyr\ApiClient\HappyrApi;
use Happyr\ApiClient\Configuration;

class myClass
{
    // ---

    public function myFunc()
    {
        $config=new Configuration('myApiIdentifier','myApiSecret');

        $api = new HappyrApi($config);
        $patterns=$api->api('patterns');

        // etc..
    }
    // ---

}
```




[1]: http://api.happyr.com
[2]: http://developer.happyr.se/wordpress-plugins/happyr-api-client
[3]: http://developer.happyr.se/libraries/happyr-api-client/configuration

