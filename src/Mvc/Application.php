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
            $this->registerModules(
                [
                    'frontend' => $this->getDI()->get('\TwistersFury\Phalcon\Core\Frontend\Module')
                ]
            );
        }

        /**
         * Run Method
         * 
         * @return string
         */
        public function run() : string {
            try {
                $this->_registerModules();

                return $this->handle()->getContent();
            } catch (Exception $thrownException) {
                $this->_handleException($thrownException);
            }

            $errorView = $this->getDI()->get('kmrSimpleView');
            return $errorView->render('exceptions\general');
        }

        /**
         * Gracefully Handles Any Thrown Exceptions
         *
         * @param \Exception $thrownException
         * @return Application
         */
        protected function _handleException(Exception $thrownException) : Application {
            $this->getDI()->get('kmrExceptionHandler')->handleException($thrownException);

            return $this;
        }
    }