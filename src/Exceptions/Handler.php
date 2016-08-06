<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Exceptions;

    use \Exception;

    /**
     * Class Handler
     *
     * Use To Handle Exceptions
     *
     * @package TwistersFury\Phalcon\Core\Exceptions
     */
    abstract class Handler {
        /**
         * Processes Passed Exception
         *
         * @param \Exception $thrownException
         *
         * @return Handler
         */
        abstract public function handleException(Exception $thrownException) : Handler;
    }