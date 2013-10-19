<?php

namespace lracicot\ImapReader;

use FilterIterator, Iterator, Countable;

class ImapFilterIterator extends FilterIterator implements Countable
{
	private $filter = null;
	private $count;

	public function __construct(Iterator $iterator, Callable $filter)
	{
		$this->filter = $filter;
		parent::__construct($iterator);

		//foreach ($this as $item) {
		//	$this->count++;
		//}
	}

	public function accept()
	{
		$filter = $this->filter;
		return $filter($this->current());
	}

	public function count()
	{
		return $this->count;
	}
}