<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/7/16
     * Time: 11:14 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Helpers;

    use Phalcon\Test\UnitTestCase;
    use TwistersFury\Phalcon\Core\Helpers\PathManager;

    class PathManagerTest extends UnitTestCase {
        public function testPaths() {
            $pathManager = new PathManager();

            $this->assertEquals(TFPC_PATH_APPLICATION . '/etc'    , $pathManager->getConfigDir());
            $this->assertEquals(TFPC_PATH_APPLICATION . '/themes' , $pathManager->getThemesDir());
            $this->assertEquals(TFPC_PATH_APPLICATION . '/modules', $pathManager->getModulesDir());
        }
    }
