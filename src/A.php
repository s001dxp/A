<?php

namespace Sdxp;


class A
{
	protected $array;

	public function __construct(array $array = [])
	{
		$this->array = $array;
	}

	public static function array(array $array)
	{
		return new self($array);
	}

	public function __invoke($key, $value)
	{
		if(count(func_get_args()) === 2)
		{

		}
	}

	public function changeKeyCase($case = CASE_LOWER)
	{
		return new self(array_change_key_case($this->array, $case));
	}


	public function chunk()
	{
	}


	public function column()
	{
	}


	public function combine()
	{
	}


	public function countValues()
	{
	}


	public function diffAssoc()
	{
	}


	public function diffKey()
	{
	}


	public function diffUassoc()
	{
	}


	public function diffUkey()
	{
	}


	public function diff()
	{
	}


	public function fillKeys()
	{
	}


	public function fill()
	{
	}


	public function filter()
	{
	}


	public function flip()
	{
	}


	public function intersectAssoc()
	{
	}


	public function intersectKey()
	{
	}


	public function intersectUassoc()
	{
	}


	public function intersectUkey()
	{
	}


	public function intersect()
	{
	}


	public function keyExists()
	{
	}


	public function keys()
	{
	}


	public function map()
	{
	}


	public function mergeRecursive()
	{
	}


	public function merge()
	{
	}


	public function multisort()
	{
	}


	public function pad()
	{
	}


	public function pop()
	{
	}


	public function product()
	{
	}


	public function push()
	{
	}


	public function rand()
	{
	}


	public function reduce()
	{
	}


	public function replaceRecursive()
	{
	}


	public function replace()
	{
	}


	public function reverse()
	{
	}


	public function search()
	{
	}


	public function shift()
	{
	}


	public function slice()
	{
	}


	public function splice()
	{
	}


	public function sum()
	{
	}


	public function udiffAssoc()
	{
	}


	public function udiffUassoc()
	{
	}


	public function udiff()
	{
	}


	public function uintersectAssoc()
	{
	}


	public function uintersectUassoc()
	{
	}


	public function uintersect()
	{
	}


	public function unique()
	{
	}


	public function unshift()
	{
	}


	public function values()
	{
	}


	public function walkRecursive()
	{
	}


	public function walk()
	{
	}


	public function arsort()
	{
	}


	public function asort()
	{
	}


	public function compact()
	{
	}


	public function count()
	{
	}


	public function current()
	{
	}


	public function each()
	{
	}


	public function end()
	{
	}


	public function extract()
	{
	}


	public function inArray()
	{
	}


	public function keyExistsKeyExists()
	{
	}


	public function key()
	{
	}


	public function krsort()
	{
	}


	public function ksort()
	{
	}


	public function list()
	{
	}


	public function natcasesort()
	{
	}


	public function natsort()
	{
	}


	public function next()
	{
	}


	public function pos()
	{
	}


	public function prev()
	{
	}


	public function range()
	{
	}


	public function reset()
	{
	}


	public function rsort()
	{
	}


	public function shuffle()
	{
	}


	public function sizeof()
	{
	}


	public function sort()
	{
	}


	public function uasort()
	{
	}


	public function uksort()
	{
	}


	public function usort()
	{
	}


}