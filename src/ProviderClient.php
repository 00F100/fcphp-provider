<?php

namespace FcPhp\Provider
{
    use FcPhp\Di\Interfaces\IDi;
    use FcPhp\Provider\Interfaces\IProviderClient;

    class ProviderClient implements IProviderClient
    {
        /**
         * Method to configure Di in providers
         *
         * @param FcPhp\Di\Interfaces\IDi $di Di Instance
         * @return void
         */
        public function getProviders(IDi $di) :IDi
        {
            return $di;
        }
    }
}
