<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/7/16
     * Time: 11:18 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Mvc;

    use Phalcon\Test\UnitTestCase;

    class ModelTest extends UnitTestCase {
        public function testCall() {
            /** @var \PHPUnit_Framework_MockObject_MockObject|\TwistersFury\Phalcon\Core\Mvc\Model $testModel */
            $testModel = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Mvc\Model')
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

            $testModel->some_property = 'something';

            $this->assertEquals('something', $testModel->getSomeProperty());
            $this->assertEquals($testModel, $testModel->setSomeProperty('something-else'));
            $this->assertEquals('something-else', $testModel->some_property);
        }
    }
