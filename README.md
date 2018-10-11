eCurring Api
===============
This package provides a simple integration of the [Official eCurring][ecurring-api-documentation] for your PHP project.

[![Build Status](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/LauLamanApps/ecurring-api/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/laulamanapps/ecurring-api/v/stable)](https://packagist.org/packages/laulamanapps/ecurring-api)
[![License](https://poser.pugx.org/laulamanapps/ecurring-api/license)](https://packagist.org/packages/laulamanapps/ecurring-api)

Installation
------------
With [composer](http://packagist.org), add:

```bash
$ composer require laulamanapps/ecurring-api
```

if you want to make use of the provided Guzzle adapter, require guzzlehttp in your composer:

```bash
$ composer require guzzlehttp/guzzle
```

Get Access Token
-----
Sign up at eCurring and get yourself an api key

Usage
-----

```php
use LauLamanApps\eCurring\eCurringClientFactory;
use LauLamanApps\eCurring\Resource\Curser\Page;

$client = eCurringClientFactory::create('<ApiKey>');

$page =  new Page(2); //-- [optional] Lets start pagination on page 2
$customers = $client->getCustomers($page);

$customers->disableAutoload(); //-- just iterate over one page

foreach ($customers as $customer) {
    // Do something with the customer
}

```

Tests
-----

This package comes with 2 types of tests: Unit and Integration.
To run them you can use the make commands in the projects root.

```bash
$ make test-unit
$ make test-integration
```

Author
-------

eCurring API has been developed by [LauLaman].

[ecurring-api-documentation]: https://developers.nest.com/documentation
[LauLaman]: https://github.com/LauLaman
