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

/**
 * All loggers produced by {@class LoggerFactory} must implement
 * this interface.
 *
 * Main logging facade, it provides a medium between Monolog/Zend
 * logging implementation, in other words - second parameter for
 * logging methods natively is not taken into account by Zend logger
 * implementation but will be emulated when writing messages with it
 * on Logade side.
 *
 * The point of using Logade facades is that when a new logging
 * frameworks emerge you will not need to update your code
 * if you decide to switch implementation.
 *
 * @author Sergei Lissovski <sergei.lissovski@gmail.com>
 */ 
interface Logger 
{
    public function debug($message, array $context = array());

    public function info($message, array $context = array());
    
    public function error($message, array $context = array());

    public function warning($message, array $context = array());

    public function critical($message, array $context = array());

    public function alert($message, array $context = array());
}
