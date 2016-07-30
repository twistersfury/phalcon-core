<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/3/16
     * Time: 9:19 PM
     */

    namespace TwistersFury\Phalcon\Core\Tests;

    use \SplFileInfo;

    class CodeCoverageTest extends \PHPUnit_Framework_TestCase {

        /**
         * @dataProvider _dpLoadFiles
         * @param string $fileName File To Test
         */
        public function testUnitTestExists(SplFileInfo $fileName) {
            $filePath = str_replace(SOURCE_PATH, TEST_PATH, $fileName->getRealPath());
            $filePath = str_replace('.php', 'Test.php', $filePath);

            $this->assertFileExists($filePath);
        }

        public function _dpLoadFiles() {
            $filesList = [];

            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(SOURCE_PATH, \RecursiveDirectoryIterator::SKIP_DOTS)) as $filePath) {
                //Ignore Config Items
                if (strstr($filePath->getRealPath(), SOURCE_PATH . '/etc') !== FALSE || $filePath->getBasename() === 'Bootstrap.php' || strstr($filePath->getRealPath(), '/Interfaces/') !== FALSE) {
                    continue;
                }

                $filesList[] = [$filePath];
            }

            return $filesList;
        }
    }