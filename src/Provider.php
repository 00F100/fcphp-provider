<?php

namespace FcPhp\Provider
{
	use ReflectionClass;
	use FcPhp\Di\Interfaces\IDi;
	use FcPhp\Provider\Interfaces\IProvider;
	use FcPhp\Provider\Interfaces\IProviderClient;
	use FcPhp\Provider\Exceptions\ProviderClassError;

	class Provider implements IProvider
	{
		/**
		 * @var FcPhp\Di\Interfaces\IDi $di
		 */
		private $di;

		/**
		 * @var array $providers
		 */
		private $providers = [];

		/**
		 * Method to construct instance of Provider
		 *
		 * @param FcPhp\Di\Interfaces\IDi $di Di instance
		 */
		public function __construct(IDi $di)
		{
			$this->di = $di;
		}

		/**
		 * Method to add providers to process
		 *
		 * @param array $providers List of providers
		 * @return FcPhp\Provider\Interfaces\IProvider
		 */
		public function addProviders(array $providers) :IProvider
		{
			$this->providers = array_merge($this->providers, $providers);
			return $this;
		}

		/**
		 * Method to make providers
		 *
		 * @return void
		 */
		public function make()
		{
			if(count($this->providers) > 0) {
				foreach($this->providers as $key => $provider) {
					$class = new ReflectionClass($provider);
					$instance = $class->newInstanceArgs();
					if(!$instance instanceof IProviderClient) {
						throw new ProviderClassError('Provider not valid! "' . $provider . '". Need implements "IProviderClient" ', 500);
					}
					$instance->getProviders($this->di);
					unset($instance);
					unset($class);
					// unset($this->providers[$key]);
				}
			}
		}
	}
}