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
            $mockDispatcher = $this->getMockBuilder('\Phalcon\Mvc\Dispatcher')
                ->setMethods(['setDefaultNamespace'])
                ->getMock();

            $mockDispatcher->expects($this->once())
                ->method('setDefaultNamespace')
                ->with('\\Controllers\\')
                ->willReturnSelf();

            $this->di->setShared('dispatcher', $mockDispatcher);

            /** @var \TwistersFury\Phalcon\Core\Mvc\AbstractModule|\PHPUnit_Framework_MockObject_MockObject $testModule */
            $testModule = $this->getMockBuilder('TwistersFury\Phalcon\Core\Mvc\AbstractModule')
                ->disableOriginalConstructor()
                ->setMethods([])
                ->getMockForAbstractClass();

            $testModule->registerServices($this->di);
        }
    }
