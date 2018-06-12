<?php

namespace FcPhp\Provider\Interfaces
{
	use FcPhp\Di\Interfaces\IDi;

	interface IProviderClient
	{
		/**
		 * Method to configure Di in providers
		 *
		 * @param FcPhp\Di\Interfaces\IDi $di Di Instance
		 * @return void
		 */
		public function getProviders(IDi $di) :void;
	}
}