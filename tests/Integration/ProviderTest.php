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

require_once('Mock.php');

class ProviderTest extends Mock
{
	private $di;
	private $provider;

	public function setUp()
	{
		$this->di = new Di(new ContainerFactory(), new InstanceFactory(), false);
		$this->provider = new Provider($this->di);
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
	public function getProviders(IDi $di) :void
	{
		$di->set('TestClass', '\TestClass');
	}
} 

class LocalProviderNonImplement
{
	public function getProviders(IDi $di) :void
	{
		$di->set('TestClass', '\TestClass');
	}
} 