<?php

namespace CotaPreco\Horus\Message;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class TaggedMessage extends Message
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @param string $tag
     * @param string $message
     */
    public function __construct($tag, $message)
    {
        parent::__construct($message);

        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}
