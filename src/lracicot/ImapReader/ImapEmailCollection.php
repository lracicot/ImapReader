<?php

namespace lracicot\ImapReader;

use Iterator, Countable;

class ImapEmailCollection implements Iterator, Countable
{
    protected $imap = null;
    protected $index = 1;
    protected $msgIds = array();

    public function __construct($imap, $msgIds)
    {
        $this->imap = $imap;
        $this->msgIds = $msgIds;
    }

    public function count()
    {
        return count($this->msgIds);
    }

    public function current()
    {
        if ($this->valid()) {
            return $this->getImapEmail($this->msgIds[$this->index]);
        }
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return isset($this->msgIds[$this->index]);
    }

    public function rewind()
    {
        $this->index = 1;
    }

    public function getIds()
    {
        return $this->msgIds;
    }

    public function getImap()
    {
        return $this->imap;
    }

    public function mergeWith(ImapEmailCollection $collection)
    {
        return self::merge($this, $collection);
    }

    public static function merge($collection1, $collection2)
    {
        if ($collection1->getImap() != $collection2->getImap()) {
            throw new Exception("ImapEmailCollection must have the same imap connection to be merged ", 1);
        }

        $ids = array_unique(array_merge($collection1->getIds(), $collection2->getIds()));

        sort($ids);

        return new ImapEmailCollection($collection1->imap, $ids);
    }

    protected function getImapEmail($msgId)
    {
        $header = imap_headerinfo($this->imap, $msgId);

        $email = new Email(
            $header->from[0]->mailbox . '@' . $header->from[0]->host,
            $header->to[0]->mailbox . '@' . $header->to[0]->host,
            $header->date,
            imap_fetchbody($this->imap, $msgId, 2)
        );

        return $email;
    }
}