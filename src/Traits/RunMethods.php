<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 10/9/16
     * Time: 6:04 PM
     */

    namespace TwistersFury\Phalcon\Core\Traits;

    /**
     * Trait RunMethods
     *
     * Adds Logic To Easily Call All Methods Of A Certain Prefix
     *
     * @package TwistersFury\Phalcon\Core\Traits
     */
    trait RunMethods {
        /**
         * Runs All Methods Starting With The Given Prefix
         *
         * @param $methodPrefix
         *
         * @return $this
         */
        protected function runMethods($methodPrefix = NULL) {
            if ($methodPrefix === NULL) {
                $methodPrefix = $this->getMethodPrefix();
            }

            $classMethods = get_class_methods(get_class($this));
            array_walk($classMethods, function($methodName) use ($methodPrefix) {
                if (substr($methodName, 0, strlen($methodPrefix)) === $methodPrefix) {
                    $this->{$methodName}();
                }
            });

            return $this;
        }

        /**
         * Retrieves Default Method Prefix
         *
         * @return string
         */
        protected function getMethodPrefix() {
            return 'run';
        }
    }