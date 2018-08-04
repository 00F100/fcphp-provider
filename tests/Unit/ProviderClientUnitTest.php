<?php
use FcPhp\Di\Interfaces\IDi;
use FcPhp\Provider\ProviderClient;
use FcPhp\Provider\Interfaces\IProviderClient;

require_once(__DIR__ . '/../Integration/Mock.php');

class ProviderClientUnitTest extends Mock
{
    private $di;
    private $provider;

    public function setUp()
    {
        $this->di = $this->createMock('\FcPhp\Di\Interfaces\IDi');
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
