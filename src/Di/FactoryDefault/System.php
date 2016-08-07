<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Di\FactoryDefault;

    use TwistersFury\Phalcon\Core\Di\FactoryDefault;
    use TwistersFury\Phalcon\Core\Interfaces\PathManager;
    use TwistersFury\Phalcon\Core\Interfaces\ModuleHelper;

    use Phalcon\Config;

    /**
     * Class System
     *
     * @package TwistersFury\Phalcon\Core\Di\FactoryDefault
     * @method PathManager getPathManager
     * @method ModuleHelper getModuleHelper
     */

    class System extends FactoryDefault {
        /**
         * Register All Databases
         *
         * @return System
         */
        protected function _loadDatabases() : System {
            if ($this->get('config')->get('databases') === NULL) {
                return $this;
            }

            foreach($this->get('config')->get('databases') as $dbName => $dbConfig) {
                $this->configureDatabase($dbName, $dbConfig);
            }

            return $this;
        }

        /**
         * @return System
         */
        protected function _registerConfig() : System {
            $this->setShared(
                'config',
                function() {
                    return $this->get('\Phalcon\Config', [include $this->getPathManager()->getConfigDir() . '/config.php']);
                }
            );

            return $this;
        }

        /**
         * Register A Database
         *
         * @param string          $databaseName
         * @param \Phalcon\Config $dbConfig
         *
         * @return System
         */
        public function configureDatabase(string $databaseName, Config $dbConfig) : System {
            $this->setShared($databaseName, function() use ($dbConfig) {
                $dbAdapter    = $dbConfig->get('adapter') ?? '\Phalcon\Db\Adapter\Pdo\Mysql';
                $dbConnection = $this->get($dbAdapter, [$dbConfig->toArray()]);
                $dbConnection->setEventsManager($this->get('eventsManager'));

                return $dbConnection;
            });

            return $this;
        }

        /**
         * Registers Primary Application
         *
         * @return System
         */
        protected function _registerApplication() : System {
            return $this->_addSimpleClass(
                'application',
                '\TwistersFury\Phalcon\Core\Mvc\Application',
                TRUE
            );
        }

        /**
         * Registers Exception Handler
         * @return System
         */
        protected function _registerExceptionHandler() : System {
            return $this->_addSimpleClass(
                'exceptionHandler',
                '\TwistersFury\Phalcon\Core\Exceptions\Handler'
            );
        }

        /**
         * Registers Normal View
         * @return System
         */
        protected function _registerView() : System {
            $this->set(
                'view',
                function() {
                    /** @var \Phalcon\Mvc\View $mainView */
                    $mainView = $this->get('\Phalcon\Mvc\View');

                    $mainView->setBasePath($this->getPathManager()->getThemesDir())
                        ->setViewsDir('/default')
                        ->setLayoutsDir('/layouts')
                        ->setPartialsDir('/partials')
                        ->registerEngines(
                            [
                                '.volt' => '\TwistersFury\Phalcon\Core\Mvc\View\Engine\Volt'
                            ]
                        );


                    return $mainView;
                }
            );

            return $this;
        }

        /**
         * Registers SimpleView
         * @return System
         */
        protected function _registerSimpleView() : System {
            $this->set(
                'simpleView',
                function() {
                    $simpleView = $this->get('\Phalcon\Mvc\View\Simple');

                    $simpleView->setViewsDir($this->getPathManager()->getThemesDir() . '/default')
                        ->registerEngines(['.volt' => '\TwistersFury\Phalcon\Core\Mvc\View\Engine\Volt']);

                    return $simpleView;
                }
            );

            return $this;
        }

        /**
         * Registers Dispatcher
         */
        protected function _registerDispatcher() : System {
            return $this->_addSimpleClass(
                'dispatcher',
                '\Phalcon\Mvc\Dispatcher',
                TRUE
            );
        }

        /**
         * Registers CriteriaFactory
         *
         * @return System
         */
        protected function _registerCriteriaFactory() : System {
            return $this->_addSimpleClass(
                'criteriaFactory',
                '\TwistersFury\Phalcon\Core\Di\CriteriaFactory',
                TRUE
            );
        }

        /**
         * Register Module Helper
         *
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault\System
         */
        protected function _registerModuleHelper() : System {
            return $this->_addSimpleClass(
                'moduleHelper',
                '\TwistersFury\Phalcon\Core\Helpers\ModuleHelper',
                TRUE
            );
        }

        protected function _registerRouter() : System {
            return $this->_addSimpleClass(
                'router',
                '\TwistersFury\Phalcon\Core\Mvc\Router',
                TRUE
            );
        }

        /**
         * Registers Path Manager
         *
         * @return System
         */
        protected function _registerPathManager() : System {
            return $this->_addSimpleClass(
                'pathManager',
                '\TwistersFury\Phalcon\Core\Helpers\PathManager',
                TRUE
            );
        }

        /**
         * Register Response Object
         *
         * @return System
         */
        protected function _registerResponse() : System {
            return $this->_addSimpleClass(
                'response',
                '\Phalcon\Mvc\Response'
            );
        }

        /**
         * Register Request Object
         * @return $this
         */
        protected function _registerRequest() : System {
            return $this->_addSimpleClass(
                'request',
                '\Phalcon\Mvc\Request',
                TRUE
            );
        }
    }