<?php

namespace FcPhp\Provider\Interfaces
{
	use FcPhp\Di\Interfaces\IDi;

	interface IProviderClient
	{
		public function getProviders(IDi $di) :IDi;
	}
}