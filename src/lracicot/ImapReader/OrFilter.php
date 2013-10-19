<?php

namespace lracicot\ImapReader;

class OrFilter
{
	protected $filters = array();

	public function __construct($filters = array())
	{
		$this->filters = $filters;
	}

	public function addFilter(Callable $filter)
	{
		$this->filters[] = $filter;
	}

	public function __invoke($email)
	{
		foreach ($this->filters as $filter) {
			if ($filter($email)) {
				return true;
			}
		}

		return false;
	}
}