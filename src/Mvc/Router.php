<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 8/2/16
     * Time: 12:01 AM
     */

    namespace TwistersFury\Phalcon\Core\Mvc;

    use \Phalcon\Mvc\Router as pRouter;
    use TwistersFury\Phalcon\Core\Traits\Injectable;

    class Router extends pRouter {
        use Injectable;
        
        public function __construct($defaultRoutes) {
            parent::__construct($defaultRoutes);

            $this->registerGroups();
        }

        public function registerGroups() {
            /** @var \Phalcon\Mvc\RouterInterface $routerInstance */
            foreach($this->getDI()->get('moduleHelper')->getModule($this->getModuleName())->getGroups() as $moduleGroup) {
                $this->mount($moduleGroup);
            }

            return $this;
        }
    }