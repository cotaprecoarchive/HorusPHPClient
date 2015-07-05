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

namespace CotaPreco\Horus\Udp;

use CotaPreco\Horus\Message\MessageInterface;
use CotaPreco\Horus\MessagePackingStrategyInterface;
use CotaPreco\Horus\MessageTransportInterface;
use CotaPreco\Horus\Udp\PackingStrategy\NullByte;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class Udp implements MessageTransportInterface
{
    /**
     * @var resource
     */
    private $socket;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var MessagePackingStrategyInterface
     */
    private $packingStrategy;

    /**
     * @param string                          $host
     * @param int                             $port
     * @param MessagePackingStrategyInterface $packingStrategy
     */
    public function __construct(
        $host,
        $port = 7600,
        MessagePackingStrategyInterface $packingStrategy = null
    ) {
        $this->host            = (string) $host;
        $this->port            = (int) $port;
        $this->socket          = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $this->packingStrategy = $packingStrategy ?: new NullByte();
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(MessageInterface $message)
    {
        /* @var callable $packingStrategy */
        $packingStrategy = $this->packingStrategy;

        $packedMessage = $packingStrategy($message);

        $bytesWritten = socket_sendto(
            $this->socket,
            $packedMessage,
            strlen($packedMessage),
            0,
            $this->host,
            $this->port
        );

        return $bytesWritten > 0;
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }
}
