<?php

namespace CotaPreco\Horus\Message;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class TagSequencedMessageTest extends TestCase
{
    /**
     * @test
     */
    public function getTags()
    {
        $message = new TagSequencedMessage(['A', 'B'], 'message');

        $this->assertCount(2, $message->getTags());
    }
}
