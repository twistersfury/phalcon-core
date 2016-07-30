<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Mvc;

    use Phalcon\Mvc\Model as pModel;
    use Phalcon\Text;

    /**
     * Class Model
     *
     * Wrapper For Phalcon Model
     *
     * @package TwistersFury\Phalcon\Core\Mvc
     */
    class Model extends pModel {

        /**
         * Overridden Magic Method - Allows For Accessing Properties Via getProperty()
         *
         * @param string $methodName
         * @param mixed  $methodArguments
         *
         * @return mixed
         */
        public function __call($methodName, $methodArguments) {
            $tempName = $this->_prepareKey($methodName);

            $typeEnd     = strpos($tempName, '_');
            $methodType  = substr($tempName, 0, $typeEnd);
            $propertyName = substr($tempName, $typeEnd + 1);

            switch($methodType) {
                case 'get':
                    return $this->readAttribute($propertyName);
                case 'set':
                    $this->writeAttribute($propertyName, $methodArguments[0]);
                    return $this;
                case 'is':
                    return $this->readAttribute($propertyName) == TRUE;
                case 'can':
                    return $this->readAttribute($propertyName) == TRUE;
            }

            return parent::__call($methodName, $methodArguments);
        }

        /**
         * Quick Prepare For Property Raw Name
         *
         * @param $keyIdent
         *
         * @return string
         */
        protected function _prepareKey($keyIdent) : string {
            return Text::uncamelize($keyIdent);
        }
    }