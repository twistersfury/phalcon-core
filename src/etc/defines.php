<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core;

    define('TFPC_DEBUG_DISABLED', 0);
    define('TFPC_DEBUG_DEFAULT' , 2);

    $debugMode = getenv('DEVELOPMENT');
    if ($debugMode === FALSE) {
        $debugMode = TFPC_DEBUG_DISABLED;
    } else if ($debugMode === TRUE) {
        $debugMode = TFPC_DEBUG_DEFAULT;
    }

    define('TFPC_DEBUG_MODE', $debugMode);

    define('TFPC_PATH_APPLICATION', isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT'] . '/../app') : '');