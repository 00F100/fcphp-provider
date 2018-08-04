<?php
use FcPhp\Di\Interfaces\IDi;
use FcPhp\Provider\Provider;
use FcPhp\Provider\Interfaces\IProvider;
use FcPhp\Provider\Interfaces\IProviderClient;

use FcPhp\Di\Di;
use FcPhp\Di\Factories\ContainerFactory;
use FcPhp\Di\Factories\InstanceFactory;

require_once(__DIR__ . '/../Integration/Mock.php');

class ProviderUnitTest extends Mock
{
    private $di;
    private $provider;

    public function setUp()
    {
        $this->di = $this->createMock('\FcPhp\Di\Interfaces\IDi');
        $this->autoload = $this->createMock('\FcPhp\Autoload\Interfaces\IAutoload');
        $this->cache = $this->createMock('\FcPhp\Cache\Interfaces\ICache');

        $this->provider = new Provider($this->di, $this->autoload, $this->cache, 'tests/*/*/config');
    }

    public function testInstance()
    {
        $this->assertTrue($this->provider instanceof IProvider);
    }

    public function testProviderClass()
    {
        $this->assertTrue($this->provider->addProviders(['\LocalProvider_providertest']) instanceof IProvider);
        $this->provider->make();
    }

    /**
     * @expectedException FcPhp\Provider\Exceptions\ProviderClassError
     */
    public function testMakeNonExtends()
    {
        $this->provider->addProviders(['LocalProviderNonImplement_providertest']);
        $this->provider->make();
    }
}

class LocalProvider_providertest implements IProviderClient
{
    public function getProviders(IDi $di) :IDi
    {
        $di->set('TestClass', '\TestClass');
        return $di;
    }
} 

class LocalProviderNonImplement_providertest
{
    public function getProviders(IDi $di) :IDi
    {
        $di->set('TestClass', '\TestClass');
        return $di;
    }
} 
