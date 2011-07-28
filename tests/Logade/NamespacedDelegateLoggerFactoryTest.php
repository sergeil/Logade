<?php

namespace Logade;

require_once __DIR__.'/../bootstrap.php';

use Logade\Adapters\NullImpl\SharedNullLogger,
    Logade\Adapters\NullImpl\SharedNullDelegateLoggerFactory,
    Logade\NamespacedDelegateLoggerFactory,
    Logade\DelegateLoggerFactory;

/**
 * @author Sergei Lissovski <sergei.lissovski@gmail.com>
 */ 
class NamespacedDelegateLoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Logade\NamespacedDelegateLoggerFactory
     */
    protected $lf;

    public function setUp()
    {
        $this->lf = new NamespacedDelegateLoggerFactory();
    }

    public function tearDown()
    {
        $this->lf = null;
    }

    public function testMapDelegateAndGetMappedDelegates()
    {
        $mockLf = $this->getMock(DelegateLoggerFactory::CLAZZ);
        $this->lf->mapDelegate('Foo\Bar', $mockLf);

        $md = $this->lf->getMappedDelegates();
        $this->assertTrue(is_array($md));
        $this->assertTrue(isset($md['Foo\Bar']));
        $this->assertSame($mockLf, $md['Foo\Bar']);
    }

    public function testMapDelegateGetLogger()
    {
        $fooBarLf = $this->getMock(DelegateLoggerFactory::CLAZZ);
        $fooBarLf->expects($this->once())
                 ->method('getLogger')
                 ->with($this->equalTo('Foo\Bar\X\Y'))
                 ->will($this->returnValue('logger-a'));

        $barBazLf = $this->getMock(DelegateLoggerFactory::CLAZZ);
        $barBazLf->expects($this->once())
                 ->method('getLogger')
                 ->with($this->equalTo('Bar\Baz\X\Y'))
                 ->will($this->returnValue('logger-b'));

        $this->lf->mapDelegate('Foo\Bar', $fooBarLf);
        $this->lf->mapDelegate('Bar\Baz', $barBazLf);

        $this->assertSame('logger-a', $this->lf->getLogger('Foo\Bar\X\Y'));
        $this->assertSame('logger-b', $this->lf->getLogger('Bar\Baz\X\Y'));
    }

    /**
     * @expectedException \Logade\Exception
     */
    public function testGetLogger_notMapped()
    {
        $this->lf->getLogger('Bar\Baz');
    }

    public function testGetLogger_idAsObj()
    {
        $localLf = $this->getMock(DelegateLoggerFactory::CLAZZ);
        $localLf->expects($this->once())
                 ->method('getLogger')
                 ->will($this->returnValue('logade-logger'));

        $this->lf->mapDelegate('Logade', $localLf);
        
        $this->assertEquals('logade-logger', $this->lf->getLogger($this));
    }
}
