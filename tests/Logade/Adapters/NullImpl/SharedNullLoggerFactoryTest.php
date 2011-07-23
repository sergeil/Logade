<?php

namespace Logade\Adapters\NullImpl;

require_once __DIR__.'/../../../bootstrap.php';

/**
 * @author Sergei Lissovski <sergei.lissovski@gmail.com>
 */ 
class SharedNullLoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLogger()
    {
        $lf = new SharedNullLoggerFactory();

        $logger = $lf->getLogger(null);
        $this->assertType(SharedNullLogger::clazz(), $logger);
        $this->assertSame($logger, $lf->getLogger(null));
    }
}
