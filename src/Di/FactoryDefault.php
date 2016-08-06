<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Di;

    use Phalcon\Di\FactoryDefault as pFactoryDefault;

    /**
     * Class FactoryDefault
     *
     * Dependency Injection Container
     *
     * @package \TwistersFury\Phalcon\Core\Di
     */
    abstract class FactoryDefault extends pFactoryDefault {
        /**
         * FactoryDefault constructor.
         */
        public function __construct() {
            $this->registerModels()
                ->registerServices()
                ->loadAdditionalServices();
        }

        /**
         * Used To Register Class Overrides
         * @return $this
         */
        public function registerModels() : FactoryDefault {
            return $this;
        }

        protected function _runMethods($methodPrefix) : FactoryDefault {
            $classMethods = get_class_methods(get_class($this));
            array_walk($classMethods, function($methodName) use ($methodPrefix) {
                if (substr($methodName, 0, strlen($methodPrefix)) === $methodPrefix) {
                    $this->{$methodName}();
                }
            });

            return $this;
        }

        /**
         * Run Methods That Start With _register
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault
         */
        public function registerServices() : FactoryDefault {
            return $this->_runMethods('_register');
        }

        /**
         * Run Methods That Start With _load
         *
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault
         */
        public function loadAdditionalServices() : FactoryDefault {
            return $this->_runMethods('_load');
        }

        /**
         * Override In Case This Isn't The Default DI
         *
         * @param string $name
         * @param null   $parameters
         *
         * @return mixed
         */
        public function get($name, $parameters = NULL) {
            try {
                return parent::get($name, $parameters);
            } catch (\Exception $error) {
                if (\Phalcon\Di::getDefault() !== NULL && $this != \Phalcon\Di::getDefault()) {
                    return \Phalcon\Di::getDefault()->get($name, $parameters);
                }

                throw $error;
            }
        }

        /**
         * Override In Case This Isn't The Default DI
         *
         * @param string $name
         * @param null   $parameters
         *
         * @return mixed
         */
        public function getShared($name, $parameters = NULL) {
            try {
                return parent::getShared($name, $parameters);
            } catch (\Exception $error) {
                if (\Phalcon\Di::getDefault() !== NULL && $this != \Phalcon\Di::getDefault()) {
                    return \Phalcon\Di::getDefault()->getShared($name, $parameters);
                }

                throw $error;
            }
        }
    }