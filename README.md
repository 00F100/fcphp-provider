# FcPHP Provider

Package do manage providers. This package use [FcPhp Di](https://github.com/00f100/fcphp-di) to inject dependency.

[![Build Status](https://travis-ci.org/00F100/fcphp-provider.svg?branch=master)](https://travis-ci.org/00F100/fcphp-provider) [![codecov](https://codecov.io/gh/00F100/fcphp-provider/branch/master/graph/badge.svg)](https://codecov.io/gh/00F100/fcphp-provider) [![Total Downloads](https://poser.pugx.org/00F100/fcphp-provider/downloads)](https://packagist.org/packages/00F100/fcphp-provider)

## How to install

Composer:
```sh
$ composer require 00f100/fcphp-provider
```

or composer.json
```json
{
	"require": {
		"00f100/fcphp-provider": "*"
	}
}
```

## How to use

#### Create class extends `IProviderClient` to inject dependencies of your application
```php
<?php

namespace Some\Example
{
	use FcPhp\Di\Interfaces\IDi;
	use FcPhp\Provider\Interfaces\IProviderClient;

	class ProviderClientExample implements IProviderClient
	{
		/**
		 * Method to configure Di in providers
		 *
		 * @param FcPhp\Di\Interfaces\IDi $di Di Instance
		 * @return void
		 */
		public function getProviders(IDi $di) :IDi
		{
			$di->set('Class', '\Class', [], ['SetConfiguration', => ['item1', 'item2', 'item3']]);
			$di->set('Class2', '\Class', ['instance' => $this->get('Class')]);
			return $di;
		}
	}
}
```

#### Create new instance of IProvider to process providers
```php
<?php

use FcPhp\Di\Facades\DiFacade;
use FcPhp\Provider\Facades\ProviderFacade;

$pathLogs = 'tests/var/logs';
$pathToAutoload = 'tests/*/*/config';

$provider = ProviderFacade::getInstance($pathToAutoload, $pathLogs);
$di = DiFacade::getInstance();

// Add new provider to process
$provider->addProviders(['Some\Example\ProviderClientExample']);

// Execute ...
$provider->make();

// Now instance of di have configuration ...
$di->make('Class2'); // Return new \Class(new \Class()) ....
```