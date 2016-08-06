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
            $this->setShared(
                'application',
                '\TwistersFury\Phalcon\Core\Mvc\Application'
            );

            return $this;
        }

        /**
         * Registers Exception Handler
         * @return System
         */
        protected function _registerExceptionHandler() : System {
            $this->set(
                'exceptionHandler',
                function() {
                    return $this->get('\TwistersFury\Phalcon\Core\Exceptions\Handler');
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

                    $simpleView->setViewsDir($this->getPathManager()->getThemesDir() . '/default');
                    $simpleView->registerEngines(['.volt' => '\TwistersFury\Phalcon\Core\Mvc\View\Engine\Volt']);

                    return $simpleView;
                }
            );

            return $this;
        }

        /**
         * Registers CriteriaFactory
         *
         * @return System
         */
        protected function _registerCriteriaFactory() : System {
            $this->set(
                'criteriaFactory',
                '\TwistersFury\Phalcon\Core\Di\CriteriaFactory'
            );

            return $this;
        }

        /**
         * Register Module Helper
         *
         * @return \TwistersFury\Phalcon\Core\Di\FactoryDefault\System
         */
        protected function _registerModuleHelper() : System {
            $this->set(
                'moduleHelper',
                '\TwistersFury\Phalcon\Core\Helpers\ModuleHelper'
            );

            return $this;
        }

        protected function _registerRouter() : System {
            $this->set(
                'router',
                '\TwistersFury\Phalcon\Core\Mvc\Router'
            );

            return $this;
        }

        /**
         * Registers Path Manager
         *
         * @return System
         */
        protected function _registerPathManager() : System {
            $this->set(
                'pathManager',
                '\TwistersFury\Phalcon\Core\Helpers\PathManager'
            );

            return $this;
        }
    }