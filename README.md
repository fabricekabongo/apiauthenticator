Installation
============

Badges:
-------
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/dfb8d9a8aa6c4e4995b7ea75a6cc2206)](https://www.codacy.com/app/fabrice-k-kabongo/apiauthenticator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=fabricekabongo/apiauthenticator&amp;utm_campaign=Badge_Grade)

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

```

Then, set the authenticator and provider to these values on `app/config/security.yml`:

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
            anonymous:    true

    providers:
        api_key_user_provider:
            id: fabricekabongo.auth0.services.apikeyuserprovider
     
    access_control:
        - { path: ^/youbaseurl, roles: ROLE_USER }
```

```yaml
# app/config/config.yml
fabrice_kabongo_auth0_api_authentication_bundle:
    valid_audiences:
        - 'https://your.service.indentifier'
    authorized_iss:
        - 'https://youraccount.auth0.com'
```

See [Auth0 APIs](https://manage.auth0.com/#/apis/)


Step 3: write functional Test for your API
-------------------------

Create a functional test and extend the `FabriceKabongo\Auth0\APIAuthenticationBundle\Test\AuthenticatedWebTestCase`
In your test cases create a client and pass it to the `setUpClient` methods with the role you want the user to have

```php
public function testMyOwnTestCase() 
{
    $client = $this->setUpClient(
        static::createClient(),
        ['ROLE_READ_PROFIL', 'ROLE_EDIT_PAYMENTINFO']
    );
    
    // do your http calls and do your test as usual
}
```


Step 4: Help me make this better and simpler. Please :)
--------------------------------------------

Todo: Write unit test (how will I mock the JWS verifier)
Todo: Create a new branch for other versions of Symfony (if works differently)
Todo: Introduce awesome new features.

I love this project and will continue to work on it. Please do the same.