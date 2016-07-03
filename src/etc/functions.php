<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core;

    /**
     * Helper Method To Define Only If Not Previously Defined
     *
     * @param $defineName
     * @param $defineValue
     */
    function define($defineName, $defineValue) {
        if (!defined($defineName)) {
            \define($defineName, $defineValue);
        }
    }