<?php
/*
 * Copyright (c) 2011 Sergei Lissovski, http://sergei.lissovski.org
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:

 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Logade;

use Logade\Adapters\NullImpl\SharedNullDelegateLoggerFactory;
 
/**
 * All loggers must be dispensed through this factory, which under the hood
 * makes use of {@class DelegateLoggerFactory} which you must provide before
 * invoking {#getLogger()};
 *
 * @author Sergei Lissovski <sergei.lissovski@gmail.com>
 */ 
final class LoggerFactory
{
    /**
     * @var \Logade\LoggerFactory
     */
    static private $instance;

    /**
     * @var \Logade\DelegateLoggerFactory
     */
    private $delegateLoggerFactory;

    /**
     * @param \Logade\DelegateLoggerFactory $factory
     * @return boolean true is delegate-logger was set and false if it was
     *                 already initialized before and the attempt was ignored
     */
    public function setDelegate(DelegateLoggerFactory $factory)
    {
        if (null === $this->delegateLoggerFactory) {
            $this->delegateLoggerFactory = $factory;
            
            return true;
        }

        return false;
    }

    /**
     * @return \Logade\DelegateLoggerFactory
     */
    public function getDelegate()
    {
        if ($this->delegateLoggerFactory === null) {
            $this->delegateLoggerFactory = new SharedNullDelegateLoggerFactory();
        }

        return $this->delegateLoggerFactory;
    }

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return $this->delegateLoggerFactory !== null;
    }

    public function getLogger($id)
    {
        return $this->getDelegate()->getLogger($id);
    }

    /**
     * @return \Logade\LoggerFactory
     */
    static public function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private function __construct() {}
}
