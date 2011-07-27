<?php

namespace Logade;

require_once __DIR__.'/../bootstrap.php';

use Logade\Adapters\NullImpl\SharedNullLogger,
    Logade\Adapters\NullImpl\SharedNullDelegateLoggerFactory;

/**
 * @author Sergei Lissovski <sergei.lissovski@gmail.com>
 */ 
class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $instance1 = LoggerFactory::getInstance();
        $this->assertSame($instance1, LoggerFactory::getInstance());

        $this->assertFalse($instance1->isInitialized());

        $logger = $instance1->getLogger('foo');
        $this->assertType(
            SharedNullLogger::clazz(),
            $logger,
            'If not delegate-logger was explicitely provided a SharedNullDelegateLoggerFactory must be used.'
        );

        $this->assertTrue($instance1->isInitialized());
        $this->assertFalse($instance1->setDelegate(new SharedNullDelegateLoggerFactory()));
    }
}
