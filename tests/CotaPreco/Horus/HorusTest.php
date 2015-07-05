<?php

namespace CotaPreco\Horus;

use CotaPreco\Horus\Message\Message;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class HorusTest extends TestCase
{
    /**
     * @test
     */
    public function invoke()
    {
        $message = new Message('message');

        /* @var \PHPUnit_Framework_MockObject_MockObject|MessageTransportInterface $transport */
        $transport = $this->getMock(MessageTransportInterface::class);

        $transport->expects($this->once())
            ->method('__invoke')
            ->with($this->equalTo($message));

        $horus = new Horus($transport);

        $horus($message);
    }
}
