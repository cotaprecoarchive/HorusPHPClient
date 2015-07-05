<?php

namespace CotaPreco\Horus\Message;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class TaggedMessageTest extends TestCase
{
    /**
     * @var TaggedMessage
     */
    private $message;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->message = new TaggedMessage('tag', 'message');
    }

    /**
     * @test
     */
    public function getTag()
    {
        $this->assertEquals('tag', $this->message->getTag());
    }

    /**
     * @test
     */
    public function getMessage()
    {
        $this->assertSame('message', $this->message->getMessage());
    }
}
