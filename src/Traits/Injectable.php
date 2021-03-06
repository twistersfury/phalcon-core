<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Traits;

    use Phalcon\Di;
    use Phalcon\DiInterface;
    use Phalcon\Session;
    use TwistersFury\Phalcon\Core\Di\FactoryDefault;

    /**
     * Trait Injectable
     *
     * Quickly Add Injection Logic
     *
     * @package TwistersFury\Phalcon\Core\Traits
     */
    trait Injectable {
        protected $_dependencyInjector = NULL;

        /**
         * @return \Phalcon\DiInterface
         */
        public function getDI() : DiInterface {
            if ($this->_dependencyInjector === NULL) {
                $this->setDI(Di::getDefault());
            }

            return $this->_dependencyInjector;
        }

        /**
         * @param DiInterface $diInterface
         * @return $this;
         */
        public function setDI(DiInterface $diInterface) {
            $this->_dependencyInjector = $diInterface;

            return $this;
        }

        /**
         * @return \Phalcon\Session
         */
        public function getSession() : Session {
            return $this->getDI()->get('session');
        }
    }