<?php
use FcPhp\Di\Interfaces\IDi;
use FcPhp\Di\Interfaces\IContainer;
use FcPhp\Di\Facades\DiFacade;
// use FcPhp\Provider\Provider;
use FcPhp\Provider\Interfaces\IProvider;
use FcPhp\Provider\Interfaces\IProviderClient;

use FcPhp\Provider\Facades\ProviderFacade;

require_once('Mock.php');

class ProviderTest extends Mock
{
    private $di;
    private $provider;

    public function setUp()
    {
        $this->provider = ProviderFacade::getInstance('tests/*/*/config', 'tests/var/cache');
        $this->di = DiFacade::getInstance();
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
        $di->set('TestClass', '\LocalProviderNonImplement');
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
