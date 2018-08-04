<?php

namespace FcPhp\Provider
{
    use ReflectionClass;
    use FcPhp\Di\Interfaces\IDi;
    use FcPhp\Provider\Interfaces\IProvider;
    use FcPhp\Provider\Interfaces\IProviderClient;
    use FcPhp\Provider\Exceptions\ProviderClassError;

    use FcPhp\Cache\Interfaces\ICache;
    use FcPhp\Autoload\Interfaces\IAutoload;

    class Provider implements IProvider
    {
        const TTL_PROVIDER = 84000;

        private $key;
        /**
         * @var FcPhp\Di\Interfaces\IDi
         */
        private $di;

        /**
         * @var FcPhp\Cache\Interfaces\ICache
         */
        private $cache;

        /**
         * @var FcPhp\Autoload\Interfaces\IAutoload
         */
        private $autoload;

        /**
         * @var array $providers
         */
        private $providers = [];

        /**
         * Method to construct instance of Provider
         *
         * @param FcPhp\Di\Interfaces\IDi $di Di instance
         */
        public function __construct(IDi $di, IAutoload $autoload, ICache $cache, string $vendorPath, bool $noCache = false)
        {
            $this->key = md5('providers');
            $this->di = $di;
            $this->cache = $cache;
            $this->autoload = $autoload;
            if(empty($this->cache->get($this->key))) {
                $this->autoload->path($vendorPath, ['provider'], ['php']);
                $this->providers = array_merge($this->providers, $this->autoload->get('provider'));
                if(!$noCache) {
                    $this->cache->set($this->key, $this->providers, self::TTL_PROVIDER);
                }
            }
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
                    unset($this->providers[$key]);
                }
            }
        }
    }
}
