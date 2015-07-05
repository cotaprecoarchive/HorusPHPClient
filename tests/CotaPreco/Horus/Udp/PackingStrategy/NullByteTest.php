<?php

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
