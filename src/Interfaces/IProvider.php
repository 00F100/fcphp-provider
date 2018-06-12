<?php

namespace FcPhp\Provider\Interfaces
{
	use FcPhp\Di\Interfaces\IDi;
	use FcPhp\Provider\Interfaces\IProvider;

	interface IProvider
	{
		public function __construct(IDi $di);

		public function addProviders(array $providers) :IProvider;

		public function make();
	}
}