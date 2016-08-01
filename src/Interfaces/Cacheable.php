<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 1:29 AM
     */

    namespace TwistersFury\Phalcon\Core\Interfaces;

    interface Cacheable {
        public function saveCache($cacheData) : Cacheable;
        public function loadCache();
        public function getCacheKey() : string;
        public function getCacheService() : string;
    }