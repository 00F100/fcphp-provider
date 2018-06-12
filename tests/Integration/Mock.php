<?php

use PHPUnit\Framework\TestCase;

class Mock extends TestCase
{
	public function getMockDi()
	{
		$di = $this->createMock('\FcPhp\Di\Interfaces\IDi');

		return $di;
	}
}

class TestClass
{
	
}