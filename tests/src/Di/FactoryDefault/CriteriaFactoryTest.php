<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/4/16
     * Time: 8:30 PM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Di\FactoryDefault;

    use Phalcon\Test\UnitTestCase;
    use TwistersFury\Phalcon\Core\Di\FactoryDefault\CriteriaFactory;

    class CriteriaFactoryTest extends UnitTestCase {
        public function testGetCriteria() {
            $mockCriteria = $this->getMockBuilder('Phalcon\Mvc\Model\Criteria')
                ->setMethods(['setModelName'])
                ->getMock();

            $mockCriteria->expects($this->once())
                ->method('setModelName')
                ->with('Some\Class\Name')
                ->willReturnSelf();

            $this->di->set('\Phalcon\Mvc\Model\Criteria', $mockCriteria);

            $testFactory = new CriteriaFactory();

            $this->assertEquals($mockCriteria, $testFactory->getCriteria('Some\Class\Name'));
        }
    }
