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
    abstract class AbstractModule implements ModuleDefinitionInterface {

        /**
         * @param DiInterface|NULL $dependencyInjector
         */
        public function registerAutoloaders(DiInterface $dependencyInjector = NULL) {}

        /**
         * @param DiInterface $dependencyInjector
         */
        public function registerServices(DiInterface $dependencyInjector) {
            $classData = explode('\\', get_called_class());

            array_pop($classData);

            $classData = implode('\\', $classData);

            $dependencyInjector->getShared('dispatcher')->setDefaultNamespace($classData . '\\Controllers\\');

            /** @var \Phalcon\Mvc\RouterInterface $routerInstance */
            $routerInstance = $dependencyInjector->getShared('router');
            foreach($dependencyInjector->getModuleHelper()->getModule($routerInstance->getModuleName())->getGroups() as $moduleGroup) {
                $routerInstance->mount($moduleGroup);
            }
        }
    }