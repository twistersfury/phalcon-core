<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/7/16
     * Time: 11:04 AM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Di\FactoryDefault;

    use Phalcon\Test\UnitTestCase;

    class SystemTest extends UnitTestCase {
        public function testConfigureDatabases() {
            /** @var \Phalcon\Config|\PHPUnit_Framework_MockObject_MockObject $dbConfig */
            $dbConfig = $this->getMockBuilder('\Phalcon\Config')
                ->disableOriginalConstructor()
                ->setMethods(
                    [
                        'get',
                        'toArray'
                    ]
                )->getMock();
            
            $dbConfig->expects($this->once())
                ->method('get')
                ->with('adapter')
                ->willReturn('Some\Adapter');
            
            $dbConfig->expects($this->once())
                ->method('toArray')
                ->willReturn(
                    [
                        'host' => 'something',
                        'user' => 'else',
                        'pass' => 'user'
                    ]
                );

            $eventsManager = $this->getMockBuilder('Phalcon\Events\Manager')
                ->disableOriginalConstructor()
                ->getMock();

            $dbAdapter = $this->getMockBuilder('\Phalcon\Db\Adapter\Pdo\Mysql')
                              ->disableOriginalConstructor()
                              ->setMethods(['setEventsManager'])
                              ->getMock();

            $dbAdapter->expects($this->once())
                ->method('setEventsManager')
                ->with($eventsManager)
                ->willReturnSelf();

            $dbConfigTest = (object) [
                'config' => NULL
            ];

            /** @var \TwistersFury\Phalcon\Core\Di\FactoryDefault\System|\PHPUnit_Framework_MockObject_MockObject $testFactory */
            $testFactory = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Di\FactoryDefault\System')
                ->disableOriginalConstructor()
                ->setMethods()
                ->getMock();

            $testFactory->set('Some\Adapter', function($configData) use ($dbAdapter, $dbConfigTest) {
                $dbConfigTest->config = $configData;

                return $dbAdapter;
            });
            
            $testFactory->set('eventsManager', $eventsManager);

            $this->assertSame($testFactory, $testFactory->configureDatabase('dbName', $dbConfig));

            $this->assertSame($dbAdapter, $testFactory->getShared('dbName'));

            $this->assertEquals(
                [
                    'host' => 'something',
                    'user' => 'else',
                    'pass' => 'user'
                ],
                $dbConfigTest->config
            );
        }
    }
