Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require fabricekabongo/auth0symfonyapiauthenticator
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new FabriceKabongo\Auth0\APIAuthenticationBundle\APIAuthenticationBundle(),
        );

        // ...
    }

    // ...
}

```Then, set the authenticator and provider to these values on `app/config/security.yml`:

```yaml
# app/config/security.yml
security:
    # ...

    firewalls:
        secured_area:
            pattern: ^/youbaseurl
            stateless: true
            simple_preauth:
                authenticator: fabricekabongo.auth0.services.apikeyuserauthenticator
            provider: api_key_user_provider

    providers:
        api_key_user_provider:
            id: fabricekabongo.auth0.services.apikeyuserprovider
```

```yaml
# app/config/config.yml
fk_auth0_api:
    valid_audiences:
        - 'https://your.service.indentifier'
    authorized_iss:
        - 'https://youraccount.auth0.com'
```

See [Auth0 APIs](https://manage.auth0.com/#/apis/)