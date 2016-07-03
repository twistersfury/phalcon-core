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

    /**
     * Trait Injectable
     *
     * Quickly Add Injection Logic
     *
     * @package TwistersFury\Phalcon\Core\Traits
     */
    trait Injectable {

        /**
         * @return \Phalcon\DiInterface
         */
        public function getDI() : DiInterface {
            return Di::getDefault();
        }
    }