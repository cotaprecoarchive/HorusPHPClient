<?php

/*
 * Copyright (c) 2015 Cota Preço
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace CotaPreco\Horus\Udp\PackingStrategy;

use CotaPreco\Horus\Message\Message;
use CotaPreco\Horus\Message\TaggedMessage;
use CotaPreco\Horus\Message\TagSequencedMessage;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class NullByteTest extends TestCase
{
    /**
     * @var NullByte
     */
    private $strategy;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->strategy = new NullByte();
    }

    /**
     * @test
     */
    public function onlyMessage()
    {
        /* @var callable $strategy */
        $strategy = $this->strategy;

        $message = new Message("message\0with\0null\0bytes");

        $this->assertNotContains("\0", $strategy($message));
    }

    /**
     * @test
     */
    public function taggedMessage()
    {
        /* @var callable $strategy */
        $strategy = $this->strategy;

        $message = new TaggedMessage("\0tag\0", "message\0");

        $packed = $strategy($message);

        $this->assertEquals(1, substr_count($packed, "\0"));
        $this->assertEquals("tag\0message", $packed);
    }

    /**
     * @test
     */
    public function tagSequencedMessage()
    {
        /* @var callable $strategy */
        $strategy = $this->strategy;

        $message = new TagSequencedMessage(['A', 'B', 'C'], 'message');

        $packed = $strategy($message);

        $this->assertEquals(5, substr_count($packed, "\0"));
        $this->assertEquals("A\0\0B\0\0C\0message", $packed);
    }
}
