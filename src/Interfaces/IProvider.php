<?php

namespace FcPhp\Provider\Interfaces
{
	use FcPhp\Di\Interfaces\IDi;
	use FcPhp\Provider\Interfaces\IProvider;
	use FcPhp\Autoload\Interfaces\IAutoload;
	use FcPhp\Cache\Interfaces\ICache;

	interface IProvider
	{
		public function __construct(IDi $di, IAutoload $autoload, ICache $cache, string $vendorPath, bool $noCache = false);

		public function addProviders(array $providers) :IProvider;

		public function make();
	}
}