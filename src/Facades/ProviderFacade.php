<?php

namespace FcPhp\Provider\Facades
{
	use FcPhp\Provider\Interfaces\IProvider;
	use FcPhp\Di\Facades\DiFacade;
	use FcPhp\Cache\Facades\CacheFacade;
	use FcPhp\Autoload\Autoload;
	use FcPhp\Provider\Provider;

	class ProviderFacade
	{
		private static $instance;

		public static function getInstance(string $exprPathAutoload, string $PathCache = null)
		{
			if(!self::$instance instanceof IProvider) {
				$di = DiFacade::getInstance();
				$autoload = new Autoload();
				$cache = CacheFacade::getInstance($PathCache);
				self::$instance = new Provider($di, $autoload, $cache, $exprPathAutoload);
			}
			return self::$instance;
		}
	}
}