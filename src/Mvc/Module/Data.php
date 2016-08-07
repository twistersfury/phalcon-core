<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 1:32 AM
     */

    namespace TwistersFury\Phalcon\Core\Mvc\Module;

    use Phalcon\Text;
    use TwistersFury\Phalcon\Core\Traits\Injectable;

    class Data {
        use Injectable;

        protected $_modulePath = '';

        public function __construct(string $modulePath) {
            $this->_modulePath = $modulePath;
        }

        public function getName() : string {
            return Text::uncamelize(basename($this->getPath()));
        }

        public function getPath() : string{
            return $this->_modulePath;
        }

        public function hasBootstrap() : bool {
            return file_exists($this->getBootstrap());
        }

        public function getBootstrap() : string {
            return $this->getPath() . '/Bootstrap.php';
        }

        public function hasRoutes() : bool {
            return count($this->getRoutes()) > 0;
        }

        public function getGroups() : array {
            $routeGroups = [];

            if (!file_exists($this->getRoutesPath())) {
                return $routeGroups;
            }

            /** @var \DirectoryIterator $directoryData */
            foreach(new \DirectoryIterator($this->getRoutesPath()) as $directoryData) {
                if ($directoryData->isDot() || $directoryData->isDir()) {
                    continue;
                }

                $routeGroups[] = include_once($directoryData->getPathname());
            }

            return $routeGroups;
        }

        public function getRoutesPath() : string {
            return $this->getPath() . '/Routes';
        }

        public function getModulePath() : string {
            return $this->getPath() . '/Module.php';
        }

        public function getModule() : string {
            return $this->getDI()->getConfig()->moduleNamespace . '\\' . Text::camelize($this->getName()) . '\Module';
        }
    }