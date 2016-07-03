<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Helpers;
    
    use TwistersFury\Phalcon\Core\Interfaces\PathManager as iPaths;

    class PathManager implements iPaths {
        public function getApplicationDir() : string {
            return TFPC_PATH_APPLICATION;
        }

        public function getConfigDir() : string {
            return $this->getApplicationDir() . '/etc';
        }

        public function getThemesDir() : string {
            return $this->getApplicationDir() . '/themes';
        }
    }