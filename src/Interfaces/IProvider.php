<?php

namespace FcPhp\Provider\Interfaces
{
    use FcPhp\Di\Interfaces\IDi;
    use FcPhp\Provider\Interfaces\IProvider;
    use FcPhp\Autoload\Interfaces\IAutoload;
    use FcPhp\Cache\Interfaces\ICache;

    interface IProvider
    {
        /**
         * Method to construct instance of Provider
         *
         * @param FcPhp\Di\Interfaces\IDi $di Di instance
         */
        public function __construct(IDi $di, IAutoload $autoload, ICache $cache, string $vendorPath, bool $noCache = false);

        /**
         * Method to add providers to process
         *
         * @param array $providers List of providers
         * @return FcPhp\Provider\Interfaces\IProvider
         */
        public function addProviders(array $providers) :IProvider;

        /**
         * Method to make providers
         *
         * @return void
         */
        public function make();
    }
}
