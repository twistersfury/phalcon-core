<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 9:04 PM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Helpers;

    use org\bovigo\vfs\vfsStream;
    use Phalcon\Test\UnitTestCase;
    use TwistersFury\Phalcon\Core\Helpers\ModuleHelper;

    class ModuleHelperTest extends UnitTestCase {
        public function testWithCache() {
            $mockData = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Module\Data')
                ->setConstructorArgs(['/Some/Path']);


            /** @var \TwistersFury\Phalcon\Core\Helpers\ModuleHelper|\PHPUnit_Framework_MockObject_MockObject $testHelper */
            $testHelper = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Helpers\ModuleHelper')
                ->setMethods(['loadCache', '_loadModules'])
                ->getMock();

            $testHelper->expects($this->once())
                ->method('loadCache')
                ->willReturn([$mockData]);

            $testHelper->expects($this->never())
                ->method('_loadModules');

            $this->assertEquals(new \ArrayIterator([$mockData]), $testHelper->getModules());
        }

        public function testWithoutCache() {
            $mockData = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Module\Data')
                             ->setConstructorArgs(['/Some/Path']);


            /** @var \TwistersFury\Phalcon\Core\Helpers\ModuleHelper|\PHPUnit_Framework_MockObject_MockObject $testHelper */
            $testHelper = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Helpers\ModuleHelper')
                               ->setMethods(['loadCache', '_loadModules'])
                               ->getMock();

            $testHelper->expects($this->once())
                       ->method('loadCache')
                       ->willReturn(NULL);

            $testHelper->expects($this->once())
                ->method('_loadModules')
                ->willReturn([$mockData]);

            $this->assertEquals(new \ArrayIterator([$mockData]), $testHelper->getModules());
        }

        public function testLoadModules() {
            $systemRoot = vfsStream::setup(
                'systemRoot',
                NULL,
                [
                    'Module'      => [],
                    'ModuleTwo'   => [],
                    'ModuleThree' => []
                ]
            );

            $pathManager = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Helpers\PathManager')
                ->setMethods(['getModulesDir'])
                ->getMock();

            $pathManager->expects($this->once())
                ->method('getModulesDir')
                ->willReturn($systemRoot->url());

            $mockData = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Module\Data')
                ->disableOriginalConstructor()
                ->getMock();

            $testHelper = new ModuleHelper();

            $rfMethod = new \ReflectionMethod('\TwistersFury\Phalcon\Core\Helpers\ModuleHelper', '_loadModules');
            $rfMethod->setAccessible(TRUE);

            $this->di->set('\TwistersFury\Phalcon\Core\Mvc\Module\Data', $mockData);
            $this->di->set('pathManager', $pathManager);

            $returnData = $rfMethod->invoke($testHelper);

            $this->assertCount(3, $returnData);
            $this->assertEquals($mockData, $returnData[0]);
        }
    }
