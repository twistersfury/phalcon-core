<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/7/16
     * Time: 11:17 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Mvc;

    use Phalcon\Test\UnitTestCase;

    class AbstractModuleTest extends UnitTestCase {
        public function testRegisterServices() {
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

            $mockRouter = $this->getMockBuilder('\Phalcon\Mvc\Router')
                ->setMethods(['getModuleName', 'mount'])
                ->disableOriginalConstructor()
                ->getMock();

            $mockRouter->expects($this->once())
                ->method('getModuleName')
                ->willReturn('module');

            $mockRouter->expects($this->once())
                ->method('mount')
                ->with($mockGroup);

            $mockDispatcher = $this->getMockBuilder('\Phalcon\Mvc\Dispatcher')
                ->setMethods(['setDefaultNamespace'])
                ->getMock();

            $mockDispatcher->expects($this->once())
                ->method('setDefaultNamespace')
                ->with('\\Controllers\\')
                ->willReturnSelf();

            $this->di->setShared('dispatcher', $mockDispatcher);
            $this->di->setShared('router', $mockRouter);

            /** @var \TwistersFury\Phalcon\Core\Mvc\AbstractModule|\PHPUnit_Framework_MockObject_MockObject $testModule */
            $testModule = $this->getMockBuilder('TwistersFury\Phalcon\Core\Mvc\AbstractModule')
                ->disableOriginalConstructor()
                ->setMethods([])
                ->getMockForAbstractClass();

            $testModule->registerServices($this->di);
        }
    }
