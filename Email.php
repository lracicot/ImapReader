<?php

namespace lracicot\ImapReader;

class Email
{
	protected $from = '';
	protected $to = '';
	protected $date = '';
	protected $body = '';

	public function __construct($from, $to, $date, $body)
	{
		$this->from = $from;
		$this->to = $to;
		$this->setDate($date);
		$this->body = $body;
	}

	/**
	 * Getter for from
	 *
	 * @return mixed
	 */
	public function getFrom()
	{
	    return $this->from;
	}
	
	/**
	 * Setter for from
	 *
	 * @param mixed $from Value to set
	 *
	 * @return self
	 */
	public function setFrom($from)
	{
	    $this->from = $from;
	    return $this;
	}
	
	/**
	 * Getter for to
	 *
	 * @return mixed
	 */
	public function getTo()
	{
	    return $this->to;
	}
	
	/**
	 * Setter for to
	 *
	 * @param mixed $to Value to set
	 *
	 * @return self
	 */
	public function setTo($to)
	{
	    $this->to = $to;
	    return $this;
	}

	/**
	 * Getter for date
	 *
	 * @return mixed
	 */
	public function getDate()
	{
	    return $this->date;
	}
	
	/**
	 * Setter for date
	 *
	 * @param mixed $date Value to set
	 *
	 * @return self
	 */
	public function setDate($date)
	{
		if (!is_object($date)) {
			$date = new \DateTime($date);
		}

	    $this->date = $date;
	    return $this;
	}

	/**
	 * Getter for body
	 *
	 * @return mixed
	 */
	public function getBody()
	{
	    return $this->body;
	}
	
	/**
	 * Setter for body
	 *
	 * @param mixed $body Value to set
	 *
	 * @return self
	 */
	public function setBody($body)
	{
	    $this->body = $body;
	    return $this;
	}

}