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
    abstract class AbstractApplication extends pApplication {
        /**
         * @return \TwistersFury\Phalcon\Core\Mvc\AbstractApplication
         */
        abstract protected function _registerModules() : AbstractApplication;

        /**
         * Run Method
         * 
         * @return string
         */
        public function run() : AbstractApplication {
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
                    $errorResponse->setContent($errorView->render('exceptions\general'));
                }
            }

            return $this;
        }

        /**
         * Gracefully Handles Any Thrown Exceptions
         *
         * @param \Exception $thrownException
         * @return AbstractApplication
         */
        protected function _handleException(Exception $thrownException) : AbstractApplication {
            $this->getDI()->get('kmrExceptionHandler')->handleException($thrownException);

            return $this;
        }
    }