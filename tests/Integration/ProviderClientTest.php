<?php

use FcPhp\Di\Di;
use FcPhp\Di\Interfaces\IDi;
use FcPhp\Provider\ProviderClient;
use FcPhp\Provider\Interfaces\IProviderClient;
use FcPhp\Di\Factories\ContainerFactory;
use FcPhp\Di\Factories\InstanceFactory;

require_once('Mock.php');

class ProviderClientTest extends Mock
{
	private $di;
	private $provider;

	public function setUp()
	{
		$this->di = new Di(new ContainerFactory(), new InstanceFactory(), false);
		$this->provider = new ProviderClient($this->di);
	}

	public function testInstance()
	{
		$this->assertTrue($this->provider instanceof IProviderClient);
	}

	public function testProviderClient()
	{
		$this->assertTrue($this->provider->getProviders($this->di) instanceof IDi);
	}
}