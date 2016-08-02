<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/7/16
     * Time: 11:17 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Mvc;

    use Phalcon\Test\UnitTestCase;

    class ApplicationTest extends UnitTestCase {
        public function testWithoutException() {
            $mockResponse = $this->getMockBuilder('\Phalcon\Http\Response')
                ->disableOriginalConstructor()
                ->setMethods(['getContent'])
                ->getMock();
            
            $mockResponse->expects($this->once())
                ->method('getContent');

            /** @var \TwistersFury\Phalcon\Core\Mvc\Application|\PHPUnit_Framework_MockObject_MockObject $testApplication */
            $testApplication = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Application')
                ->disableOriginalConstructor()
                ->setMethods(['_registerModules', 'handle'])
                ->getMock();
            
            $testApplication->expects($this->once())
                ->method('handle')
                ->willReturn($mockResponse);
            
            $testApplication->expects($this->once())
                ->method('_registerModules')
                ->willReturnSelf();
            
            $testApplication->run();
        }

        public function testWithException() {
            $this->markTestIncomplete('To Be Implemented');
        }

        public function testRegisterModules() {
            $mockModule = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Module\Data')
                ->setConstructorArgs(['\Some\Module'])
                ->setMethods(['getName', 'getPath', 'getModule'])
                ->getMock();

            $mockModule->expects($this->once())
                ->method('getName')
                ->willReturn('some_module');

            $mockModule->expects($this->once())
                ->method('getPath')
                ->willReturn('Some\Path');

            $mockModule->expects($this->once())
                ->method('getModule')
                ->willReturn('Some\Module');
            
            $arrayData = [
                $mockModule
            ];

            $arrayIterator = new \ArrayIterator($arrayData);

            $mockHelper = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Helpers\ModuleHelper')
                ->setMethods(['getModules'])
                ->getMock();

            $mockHelper->expects($this->once())
                ->method('getModules')
                ->willReturn($arrayIterator);

            $this->di->set('moduleHelper', $mockHelper);

            /** @var \TwistersFury\Phalcon\Core\Mvc\Application|\PHPUnit_Framework_MockObject_MockObject $testApplication */
            $testApplication = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Application')
                                    ->setConstructorArgs([$this->di])
                                    ->setMethods(['registerModules'])
                                    ->getMock();

            $testApplication->expects($this->once())
                ->method('registerModules')
                ->with(
                    [
                        'some_module' => [
                            'className' => 'Some\Module',
                            'path'      => 'Some\Path'
                        ]
                    ],
                    TRUE
                )
                ->willReturnSelf();


            $rfApplication = new \ReflectionMethod('\TwistersFury\Phalcon\Core\Mvc\Application', '_registerModules');
            $rfApplication->setAccessible(TRUE);

            $this->assertEquals($testApplication, $rfApplication->invoke($testApplication));
        }
    }
