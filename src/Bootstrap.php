<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core;

    use Phalcon\Loader;

    include __DIR__ . '/etc/functions.php';
    include __DIR__ . '/etc/defines.php';

    //Let Phalcon Handle Auto-Loading
    (new Loader())->registerNamespaces(
        [
            'TwistersFury\Phalcon\Core' => __DIR__
        ]
    )->register();
