<?php
    /**
     * Created by PhpStorm.
     * User: fenikkusu
     * Date: 7/31/16
     * Time: 9:07 PM
     */
    namespace TwistersFury\Phalcon\Core\Tests\Traits;

    use Phalcon\Test\UnitTestCase;
    use TwistersFury\Phalcon\Core\Traits\Cacheable;

    class MockCacheable implements \TwistersFury\Phalcon\Core\Interfaces\Cacheable {
        use Cacheable;
    }

    class CacheableTest extends UnitTestCase {
        /** @var \TwistersFury\Phalcon\Core\Traits\Cacheable|\PHPUnit_Framework_MockObject_MockObject */
        protected $_testCacheable = NULL;

        /** @var \Phalcon\Cache\Frontend\Data|\PHPUnit_Framework_MockObject_MockObject */
        protected $_mockCache = NULL;

        public function setUp() {
            parent::setUp();

            $this->_testCacheable = $this->getMockBuilder('\TwistersFury\Phalcon\Core\Tests\Traits\MockCacheable')
                ->setMethods(['getCacheService', 'getCacheKey'])
                ->getMock();

            $this->_testCacheable->expects($this->exactly(3))
                ->method('getCacheService')
                ->willReturn('someCache');

            $this->_testCacheable->expects($this->once())
                ->method('getCacheKey')
                ->willReturn('someKey');


            $this->_mockCache = $this->getMockBuilder('\Phalcon\Cache\Frontend\Data')
                ->disableOriginalConstructor()
                ->setMethods(['save', 'get'])
                ->getMock();
        }

        public function testSaveCache() {
            $this->assertSame($this->_testCacheable, $this->_testCacheable->saveCache(['something' => 'else']));

            $this->_mockCache->expects($this->once())
                ->method('save')
                ->with('someKey', ['something' => 'else-again']);

            $this->di->set('someCache', $this->_mockCache);

            $this->assertSame($this->_testCacheable, $this->_testCacheable->saveCache(['something' => 'else-again']));
        }

        public function testLoadCache() {
            $this->assertEquals(NULL, $this->_testCacheable->loadCache());

            $this->_mockCache->expects($this->once())
                             ->method('get')
                             ->with('someKey')
                            ->willReturn('someValue');

            $this->di->set('someCache', $this->_mockCache);

            $this->assertEquals('someValue', $this->_testCacheable->loadCache());
        }
    }
