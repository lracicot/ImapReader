<?php

namespace lracicot\PhpImapReader;

class EmailDecoder
{
	private $str;

	public function __construct($str)
	{
		$this->str = $str;
	}

	public static function getInstance($str)
	{
		return new EmailDecoder($str);
	}

	public static function decodeStr($str)
	{
		return EmailDecoder::getInstance($str)->decode();
	}

	public function decode()
	{
		return utf8_decode(urldecode($this->emailToUrl($this->str)));
	}

	protected function emailToUrl($str)
	{
		//$str = str_replace("=\r\n", "\n\r", $str);
		$str = str_replace("=\r\n", "", $str);

		$chars = urlencode('éÉèÈêÊàÀùÙçÇ');

		$emailsEncoded = explode(',', str_replace('%', ',=', $chars));
		$urlEncoded = explode(',', str_replace('%', ',%', $chars));

		return str_replace($emailsEncoded, $urlEncoded, $str);
	}
}