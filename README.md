HappyR PHP API client
=====================

This PHP library is a client to the API at [HappyRecruiting.se][1].

If you are using WordPress you may want to check out our [WordPress plugin][2] that
integrates with this library. It may makes life simpler for you.



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

There is a few mandatory configuration parameters. Thay are 'username' and 'token'. You will get them both
from the [HappyRecruiting website][1]. You may add those in the Configuration.php or set them in runtime.

You find a the full configuration reference at [developer.happyr.se][3]

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
        $config=new Configuration('myUsername','myToken');

        $api=new HappyrApi($config);
        $companies=$api->getCompanies();
        // etc..
    }
    // ---

}
```




[1]: http://happyrecruiting.se
[2]: http://developer.happyr.se/wordpress-plugins/happyr-api-client
[3]: http://developer.happyr.se/php-libraries/happyrecruiting-api-client/configuration

