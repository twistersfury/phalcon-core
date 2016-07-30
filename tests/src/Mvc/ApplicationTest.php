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
            
        }
    }
