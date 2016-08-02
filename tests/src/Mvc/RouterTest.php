<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 8/2/16
     * Time: 12:03 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Mvc;

    use Phalcon\Test\UnitTestCase;

    class RouterTest extends UnitTestCase {
        public function testRegisterGroups() {
            $mockGroup = $this->getMockBuilder('\Phalcon\Mvc\Router\Group')
                              ->disableOriginalConstructor()
                              ->getMock();

            $mockData = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Module\Data')
                             ->setMethods(['getGroups'])
                             ->disableOriginalConstructor()
                             ->getMock();

            $mockData->expects($this->once())
                     ->method('getGroups')
                     ->willReturn([$mockGroup]);

            $mockHelper = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Helpers\ModuleHelper')
                               ->setMethods(['getModule'])
                               ->getMock();

            $mockHelper->expects($this->once())
                       ->method('getModule')
                       ->with('module')
                       ->willReturn($mockData);

            $this->di->set('moduleHelper', $mockHelper);

            /** @var \TwistersFury\Phalcon\Core\Mvc\Router|\PHPUnit_Framework_MockObject_MockObject $mockRouter */
            $mockRouter = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Router')
                               ->setMethods(['getModuleName', 'mount'])
                               ->disableOriginalConstructor()
                               ->getMock();

            $mockRouter->expects($this->once())
                       ->method('getModuleName')
                       ->willReturn('module');

            $mockRouter->expects($this->once())
                       ->method('mount')
                       ->with($mockGroup);

            $this->assertSame($mockRouter, $mockRouter->registerGroups());
        }
    }
