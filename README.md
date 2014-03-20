HappyR PHP API client
=====================

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
        $config=new Configuration('myApiIdentifier','myApiSecret');

        $api = new HappyRApi($config);
        $patterns=$api->api('patterns');

        // etc..
    }
    // ---

}
```




[1]: http://api.happyr.com
[2]: http://developer.happyr.se/wordpress-plugins/happyr-api-client
[3]: http://developer.happyr.se/libraries/happyr-api-client/configuration

