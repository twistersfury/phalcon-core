<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 1:23 AM
     */

    namespace TwistersFury\Phalcon\Core\Traits;

    use \TwistersFury\Phalcon\Core\Interfaces\Cacheable as iCacheable;

    trait Cacheable {
        use Injectable;

        public function saveCache($cacheData) : iCacheable {
            if ($this->getDI()->has($this->getCacheService())) {
                $this->getDI()->get($this->getCacheService())->save($this->getCacheKey(), $cacheData);
            }

            return $this;
        }

        public function loadCache() {
            if ($this->getDI()->has($this->getCacheService())) {
                return $this->getDI()->get($this->getCacheService())->get($this->getCacheKey());
            }

            return NULL;
        }

        public function getCacheService() : string {
            return 'longCache';
        }

        public function getCacheKey() : string {
            return str_replace('\\', '-', strtolower(get_called_class()));
        }
    }