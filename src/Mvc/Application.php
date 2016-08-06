<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Mvc;
    
    use \Exception;

    use \Phalcon\Mvc\Application as pApplication;
    use Phalcon\Text;
    use TwistersFury\Phalcon\Core\Mvc\Module\Data;

    /**
     * Class Application
     *
     * Primary Phalcon Application
     *
     * @package TwistersFury\Phalcon\Core\Mvc
     */
     class Application extends pApplication {
        /**
         * @return \TwistersFury\Phalcon\Core\Mvc\Application
         */
        protected function _registerModules() : Application {
            $moduleDefinitions = [];

            /** @var Data $moduleDefinition */
            foreach($this->getDI()->getModuleHelper()->getModules() as $moduleDefinition) {
                $moduleDefinitions[Text::uncamelize($moduleDefinition->getName())] = [
                    'className' => $moduleDefinition->getModule(),
                    'path'      => $moduleDefinition->getPath()
                ];
            }

            return $this->registerModules(
                $moduleDefinitions,
                TRUE
            );
        }

        /**
         * Run Method
         * 
         * @return Application
         */
        public function run() : Application {
            try {
                $this->_registerModules();

                echo $this->handle()->getContent();
            } catch (Exception $thrownException) {
                $this->_handleException($thrownException);

                /** @var \Phalcon\Http\Response $errorResponse */
                $errorResponse = $this->getDI()->get('\Phalcon\Http\Response');

                $errorResponse->setStatusCode(500, 'An Error Occurred');
                if ($this->getDI()->has('simpleView')) {
                    $errorView     = $this->getDI()->get('simpleView');
                    $errorResponse->setContent($errorView->render('/exceptions/general'));
                }

                $errorResponse->send();
            }

            return $this;
        }

        /**
         * Gracefully Handles Any Thrown Exceptions
         *
         * @param \Exception $thrownException
         * @return Application
         */
        protected function _handleException(Exception $thrownException) : Application {
            $this->getDI()->get('exceptionHandler')->handleException($thrownException);

            return $this;
        }
    }