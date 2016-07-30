<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/3/16
     * Time: 7:47 PM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Di;

    use Phalcon\Test\UnitTestCase;

    class FactoryDefaultTest extends UnitTestCase {
        public function testConstruct() {
            /** @var \TwistersFury\Phalcon\Core\Di\FactoryDefault|\PHPUnit_Framework_MockObject_MockObject $factoryTest */
            $factoryTest = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Di\FactoryDefault')
                ->setMethods(
                    [
                        '_registerService',
                        '_registerAnotherService',
                        '_loadSomething'
                    ]
                )
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

            $factoryTest->expects($this->once())
                ->method('_registerService')
                ->willReturnSelf();

            $factoryTest->expects($this->once())
                 ->method('_registerAnotherService')
                 ->willReturnSelf();

            $factoryTest->expects($this->once())
                 ->method('_loadSomething')
                 ->willReturnSelf();

            $factoryTest->registerServices()
                ->loadAdditionalServices();
        }
    }
