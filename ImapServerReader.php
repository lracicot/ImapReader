<?php

namespace lracicot\PhpImapReader;

class ImapServerReader
{
	protected $inbox = null;

	public function __construct($hostname, $username, $password)
	{
		$this->inbox = imap_open($hostname, $username, $password);

		if (!$this->inbox) {
			throw new Exception('Cannot connect to Gmail: ' . imap_last_error());
		}
	}

	public function __destruct()
	{
		imap_close($this->inbox);
	}

	public function getAll()
	{
		$all = array_keys(imap_search($this->inbox, 'ALL'));

		return new ImapEmailCollection($this->inbox, $all);
	}

	public function getConversation($address1, $address2)
	{
		$conv = array_merge(
			imap_search($this->inbox, 'FROM "'.$address1.'" TO "'.$address2.'"', SE_UID),
			imap_search($this->inbox, 'FROM "'.$address2.'" TO "'.$address1.'"', SE_UID)
		);

		sort($conv);

		return new ImapEmailCollection($this->inbox, $conv);
	}
}