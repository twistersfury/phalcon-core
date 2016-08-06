<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 12:56 AM
     */

    namespace TwistersFury\Phalcon\Core\Helpers;

    use TwistersFury\Phalcon\Core\Interfaces\Cacheable as iCacheable;
    use \TwistersFury\Phalcon\Core\Interfaces\ModuleHelper  as iModuleHelper;
    use TwistersFury\Phalcon\Core\Mvc\Module\Data;
    use TwistersFury\Phalcon\Core\Traits\Cacheable as tCacheable;

    /**
     * Class ModuleHelper
     *
     * @package TwistersFury\Phalcon\Core\Helpers
     * @method \TwistersFury\Phalcon\Core\Di\FactoryDefault\System getDI
     */
    class ModuleHelper implements iModuleHelper, iCacheable {
        use tCacheable;

        public function getModules() : \ArrayIterator {
            $moduleList = $this->loadCache();
            if (!$moduleList) {
                $moduleList = $this->_loadModules();
                $this->saveCache($moduleList);
            }

            return $this->getDI()->get('\ArrayIterator', [$moduleList]);
        }

        protected function _loadModules() {
            $modulesArray = [];

            /** @var \DirectoryIterator $directoryInfo */
            foreach(new \DirectoryIterator($this->getDI()->getPathManager()->getModulesDir()) as $directoryInfo) {
                if ($directoryInfo->isFile() || $directoryInfo->isDot()) {
                    continue;
                }

                /** @var Data $moduleData */
                $moduleData = $this->getDI()->get('\TwistersFury\Phalcon\Core\Mvc\Module\Data', [$directoryInfo->getPath()]);

                $modulesArray[$moduleData->getName()] = $moduleData;
            }

            return $modulesArray;
        }

        public function hasModule($moduleName) {
            return isset($this->getModules()[$moduleName]);
        }

        public function getModule($moduleName) : Data {
            if ($moduleName === NULL) {
                throw new \InvalidArgumentException("Module Name Cannot Be Null");
            } if (!$this->hasModule($moduleName)) {
                throw new \Exception("Module Not Found: " . $moduleName);
            }

            return $this->getModules()[$moduleName];
        }
    }