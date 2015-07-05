<?php

namespace CotaPreco\Horus\Message;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class TagSequencedMessage extends Message
{
    /**
     * @var string[]
     */
    private $tags;

    /**
     * @param string[] $tags
     * @param string   $message
     */
    public function __construct(array $tags, $message)
    {
        parent::__construct($message);

        $this->tags = $tags;
    }

    /**
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }
}
