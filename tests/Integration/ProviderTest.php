<?php
use FcPhp\Di\Interfaces\IDi;
use FcPhp\Di\Interfaces\IContainer;
use FcPhp\Di\Facades\DiFacade;
use FcPhp\Provider\Provider;
use FcPhp\Provider\Interfaces\IProvider;
use FcPhp\Provider\Interfaces\IProviderClient;

use FcPhp\Di\Di;
use FcPhp\Di\Factories\ContainerFactory;
use FcPhp\Di\Factories\InstanceFactory;
use FcPhp\Autoload\Autoload;
use FcPhp\Cache\Facades\CacheFacade;

require_once('Mock.php');

class ProviderTest extends Mock
{
	private $di;
	private $provider;

	public function setUp()
	{
		$this->di = DiFacade::getInstance();
		$this->provider = new Provider($this->di, new Autoload(), CacheFacade::getInstance('tests/var/logs'), 'tests/*/*/config');
	}

	public function testInstance()
	{
		$this->assertTrue($this->provider instanceof IProvider);
	}

	public function addProviders()
	{
		$this->provider->addProviders(['LocalProvider']);
	}

	public function testMake()
	{
		$this->provider->addProviders(['LocalProvider']);
		$this->provider->make();
		$this->assertTrue($this->di->get('TestClass') instanceof IContainer);
	}

	/**
	 * @expectedException FcPhp\Provider\Exceptions\ProviderClassError
	 */
	public function testMakeNonExtends()
	{
		$this->provider->addProviders(['LocalProviderNonImplement']);
		$this->provider->make();
	}
}

class LocalProvider implements IProviderClient
{
	public function getProviders(IDi $di) :IDi
	{
		$di->set('TestClass', '\TestClass');
		return $di;
	}
} 

class LocalProviderNonImplement
{
	public function getProviders(IDi $di) :IDi
	{
		$di->set('TestClass', '\TestClass');
		return $di;
	}
} 