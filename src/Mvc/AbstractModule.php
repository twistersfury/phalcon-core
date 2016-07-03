<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Mvc;

    use Phalcon\DiInterface;
    use Phalcon\Mvc\ModuleDefinitionInterface;

    /**
     * Class AbstractModule
     *
     * @package TwistersFury\Phalcon\Core\Mvc
     */
    class AbstractModule implements ModuleDefinitionInterface {

        /**
         * @param DiInterface|NULL $dependencyInjector
         */
        public function registerAutoloaders(DiInterface $dependencyInjector = NULL) : void {}

        /**
         * @param DiInterface $dependencyInjector
         */
        public function registerServices(DiInterface $dependencyInjector) : void {
            $sClass = get_called_class();
            $sClass = explode('\\', $sClass);

            array_pop($sClass);

            $sClass = implode('\\', $sClass);

            $dependencyInjector->getShared('dispatcher')->setDefaultNamespace($sClass . '\\Controllers\\');
        }
    }