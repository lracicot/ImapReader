<?php

namespace lracicot\PhpImapReader;

use lracicot\PhpImapReader\EmailDecoder;

class Email
{
	protected $contents = '';

	public function __construct($contents)
	{
		$this->contents = $contents;
	}

	public function getFrom()
	{
		$pattern = '/From:(.*) <?(\b[ A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b)>?/';
		preg_match($pattern, $this->contents, $matches);

		return array_pop($matches);
	}

	public function getTo()
	{
		$pattern = '/To:(.*) <?(\b[ A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b)>?/';
		preg_match($pattern, $this->contents, $matches);

		return array_pop($matches);
	}

	public function getDate()
	{
		$pattern = '/Date: (.*)/';
		preg_match($pattern, $this->contents, $matches);

		$timeStr = array_pop($matches);

		return new \DateTime('@'.strtotime($timeStr));
	}

	public function getBody()
	{
		$pattern = '/\r?\n\r?\n(.*)/s';
		preg_match($pattern, $this->contents, $matches);

		$message = array_pop($matches);

		return  EmailDecoder::decodeStr($message);
	}

	public function isValid()
	{
		return $this->contents != '';
	}
}