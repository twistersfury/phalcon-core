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
            $classMethods = get_class_methods(__CLASS__);

            //Call All Method That Begin With '_register'
            array_walk($classMethods, function($methodName) {
                if (substr($methodName, 0, 9) === '_register') {
                    $this->{$methodName};
                }
            });

            //Call All Methods That Begin With '_load'
            array_walk($classMethods, function($methodName) {
                if (substr($methodName, 0, 5) === '_load') {
                    $this->{$methodName};
                }
            });
        }
    }