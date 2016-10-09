<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Di;

    use Phalcon\Di\Exception;
    use Phalcon\Di\FactoryDefault as pFactoryDefault;
    use TwistersFury\Phalcon\Core\Traits\RunMethods;

    /**
     * Class FactoryDefault
     *
     * Dependency Injection Container
     *
     * @package \TwistersFury\Phalcon\Core\Di
     */
    abstract class FactoryDefault extends pFactoryDefault {
        use RunMethods;

        /**
         * FactoryDefault constructor.
         */
        public function __construct() {
            parent::__construct();

            $this->registerModels()
                ->registerServices()
                ->loadAdditionalServices();
        }

        /**
         * Helper For Quick Class Additions
         *
         * @param      $serviceName
         * @param      $className
         * @param bool $isShared
         *
         * @return $this
         */
        protected function _addSimpleClass($serviceName, $className, $isShared = FALSE) {
            $this->{ $isShared ? 'setShared' : 'set'}($serviceName, function() use ($className) {
                return $this->get($className, func_get_args());
            });

            return $this;
        }

        /**
         * Used To Register Class Overrides
         * @return $this
         */
        public function registerModels() : FactoryDefault {
            return $this;
        }

        /**
         * Run Methods That Start With _register
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault
         */
        public function registerServices() : FactoryDefault {
            return $this->runMethods('_register');
        }

        /**
         * Run Methods That Start With _load
         *
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault
         */
        public function loadAdditionalServices() : FactoryDefault {
            return $this->runMethods('_load');
        }

        /**
         * Override In Case This Isn't The Default DI
         *
         * @param string $name
         * @param null   $parameters
         *
         * @return mixed
         * @throws Exception
         */
        public function get($name, $parameters = NULL) {
            try {
                return parent::get($name, $parameters);
            } catch (Exception $error) {
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
         * @throws Exception
         */
        public function getShared($name, $parameters = NULL) {
            try {
                return parent::getShared($name, $parameters);
            } catch (Exception $error) {
                if (\Phalcon\Di::getDefault() !== NULL && $this != \Phalcon\Di::getDefault()) {
                    return \Phalcon\Di::getDefault()->getShared($name, $parameters);
                }

                throw $error;
            }
        }
    }