<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 12:56 AM
     */

    namespace TwistersFury\Phalcon\Core\Interfaces;

    interface ModuleHelper {
        public function getModules() : \ArrayIterator;
    }