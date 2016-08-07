<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 8/7/16
     * Time: 7:20 PM
     */

    namespace TwistersFury\Phalcon\Core\Mvc;

    use \Phalcon\Mvc\View as pView;

    class View extends pView {
        public function render($controllerName, $actionName, $params = NULL) {
            $controllerName = $this->getDI()->get('router')->getModuleName() . '/' . $controllerName;
            
            parent::render($controllerName, $actionName, $params);
        }
    }