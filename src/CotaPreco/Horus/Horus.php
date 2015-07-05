<?php

namespace CotaPreco\Horus;

use CotaPreco\Horus\Message\MessageInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class Horus
{
    /**
     * @var MessageTransportInterface
     */
    private $transport;

    /**
     * @param MessageTransportInterface $transport
     */
    public function __construct(MessageTransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param MessageInterface $message
     */
    public function __invoke(MessageInterface $message)
    {
        /* @var callable $transport */
        $transport = $this->transport;

        $transport($message);
    }
}
