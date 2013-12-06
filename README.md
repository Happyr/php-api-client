HappyR PHP API client
=====================

This PHP library is a client to the API at [api.happyr.com][1].

If you are using WordPress you may want to check out our [WordPress plugin][2] that
integrates with this library. It might make life simpler for you.



Installation
------------

Install it with Composer!

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/php-api-client": "1.0.*",
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

There is a few mandatory configuration parameters. They are 'username' and 'token'. You will get them both
from the [HappyR-API website][1]. You may add those in the Configuration.php or set them in runtime.

You find a the full configuration reference [here][3].

Usage
-----
```php
use HappyR\ApiClient\HappyRApi;
use HappyR\ApiClient\Configuration;

class myClass
{
    // ---

    public function myFunc()
    {
        $config=new Configuration('myUsername','myToken');

        $api = new HappyRApi($config);
        $profilePatterns = $api->getPotentialApi()->getPatterns();
        // etc..
    }
    // ---

}
```




[1]: http://api.happyr.com
[2]: http://developer.happyr.se/wordpress-plugins/happyr-api-client
[3]: http://developer.happyr.se/libraries/happyr-api-client/configuration

