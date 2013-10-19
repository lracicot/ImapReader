<?php

namespace lracicot\PhpImapReader;

use Iterator;

class ImapFileReader implements Iterator
{
	// File handle
	protected $fh = null;

	protected $currentEmailFile = null;
	protected $currentEmail = null;
	protected $position = 0;
	private $buffer = '';

	public function __construct($fileHandle)
	{
		$this->fh = $fileHandle;
		$this->next();
	}

	public function __destruct()
	{
		fclose($this->fh);
	}

	public function current()
	{
		return $this->currentEmail;
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		$line = fgets($this->fh);

		do {
		   
		   $this->buffer .= $line;
		}
		while ( 
			(($line = fgets($this->fh)) && substr($line, 0, 7) != 'From - ')
		);

		$this->position++;

		$this->currentEmailFile = new RawEmail($this->buffer);
		$this->currentEmail = null;

		if ($this->valid()) {
			$this->currentEmail = new Email(
				$this->currentEmailFile->getFrom(),
				$this->currentEmailFile->getTo(),
				$this->currentEmailFile->getDate(),
				$this->currentEmailFile->getBody()
			);
		}

		$this->buffer = $line;
	}

	public function rewind()
	{
		rewind($this->fh);
	}

	public function valid()
	{
		return $this->currentEmailFile->isValid();
	}
}