<?php

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
