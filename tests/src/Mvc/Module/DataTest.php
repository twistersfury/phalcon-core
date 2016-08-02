<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 9:38 PM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Mvc\Module;

    use org\bovigo\vfs\vfsStream;
    use Phalcon\Test\UnitTestCase;
    use TwistersFury\Phalcon\Core\Mvc\Module\Data;

    class DataTest extends UnitTestCase {
        /** @var Data */
        private $_testData = NULL;

        public function setUp() {
            parent::setUp();

            $this->_testData = new Data('/Some/Path');
        }

        public function testGetName() {
            $this->assertEquals('path', $this->_testData->getName());
        }

        public function testGetPath() {
            $this->assertEquals('/Some/Path', $this->_testData->getPath());
        }

        public function testGetModule() {
            $this->assertEquals('/Some/Path/Module.php', $this->_testData->getModule());
        }

        public function testGetBootstrap() {
            $this->assertEquals('/Some/Path/Bootstrap.php', $this->_testData->getBootstrap());
        }

        public function testGetRoutesPath() {
            $this->assertEquals('/Some/Path/Routes', $this->_testData->getRoutesPath());
        }

        public function testGetGroups() {
            $systemRoot = vfsStream::setup(
                'systemRoot',
                NULL,
                [
                    'Module' => [
                        'Routes' => [
                            'Group.php' => '<?php return "A";',
                            'Location.php' => '<?php return "B";',
                            'AnotherGroup.php' => '<?php return "C";'
                        ]
                    ]
                ]
            );

            $this->_testData = new Data(vfsStream::url('systemRoot/Module'));

            $this->assertEquals(
                [
                    'A',
                    'B',
                    'C'
                ],
                $this->_testData->getGroups()
            );
        }
    }
