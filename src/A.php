<?php

namespace Sdxp;

class A implements \ArrayAccess, \Iterator, \Countable
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

	public function changeKeyCase($case = CASE_LOWER)
	{
		return new self(array_change_key_case($this->array, $case));
	}

	public function chunk($size, $preserve_keys = false)
	{
		return new self(array_map(function ($value) {
			return new A($value);
		}, array_chunk($this->array, $size, $preserve_keys)));
	}

	public function column($column)
	{
		return new self(array_column($this->array, $column));
	}

	public function combineLeft(array $array)
	{
		return new self(array_combine($array, $this->array));
	}

	public function combineRight(array $array)
	{
		return new self(array_combine($this->array, $array));
	}

	public function countValues()
	{
		return new self(array_count_values($this->array));
	}

	public function diffAssoc(array $array, ...$otherArrays)
	{
		return new self(array_diff_assoc($this->array, $array, ...$otherArrays));
	}

	public function diffKey(array $array, ...$otherArrays)
	{
		return new self(array_diff_key($this->array, $array, ...$otherArrays));
	}

	public function diffUAssoc(array $array, callable $callback)
	{
		return new self(array_diff_uassoc($this->array, $array, $callback));
	}

	public function diffUKey(array $array, callable $callback)
	{
		return new self(array_diff_ukey($this->array, $array, $callback));
	}

	/**
	 * @param       $array
	 * @param array ...$otherArrays
	 * @return A
	 */
	public function diff(array $array, ...$otherArrays)
	{
		return new self(array_diff($this->array, $array, ...$otherArrays));
	}

	public function filter(callable $callback)
	{
		return new self(array_filter($this->array, $callback, ARRAY_FILTER_USE_BOTH));
	}

	public function flip()
	{
		return new self(array_flip($this->array));
	}

	public function intersectAssoc(array $array, ...$otherArrays)
	{
		return new self(array_intersect_assoc($this->array, $array, ...$otherArrays));
	}

	public function intersectKey(array $array, ...$otherArrays)
	{
		return new self(array_intersect_key($this->array, $array, ...$otherArrays));
	}

	public function intersectUAssoc(array $array, callable $callback)
	{
		return new self(array_intersect_uassoc($this->array, $array, $callback));
	}

	public function intersectUKey(array $array, callable $callback)
	{
		return new self(array_intersect_ukey($this->array, $array, $callback));
	}

	public function intersect(array $array, ...$otherArrays)
	{
		return new self(array_intersect($this->array, $array, ...$otherArrays));
	}

	public function keyExists($key)
	{
		return array_key_exists($key, $this->array);
	}

	public function has($key)
	{
		return $this->keyExists($key);
	}

	public function keys()
	{
		return new self(array_keys($this->array));
	}

	public function map(callable $callback)
	{
		return new self(array_map($callback, $this->array));
	}

	public function mergeRecursive(array $array)
	{
		return new self(array_merge_recursive($this->array, $array));
	}

	public function merge(array $array)
	{
		return new self(array_merge($this->array, $array));
	}

	public function pad(int $size, $padding)
	{
		return new self(array_pad($this->array, $size, $padding));
	}

	public function pop()
	{
	}

	public function product()
	{
		return array_product($this->array);
	}

	public function push($value, ...$moreValues)
	{
		$copy = $this->array;
		if(empty($moreValues))
		{
			$copy[] = $value;
		}
		else
		{
			array_push($copy, ...$moreValues);
		}
		return new self($copy);
	}

	public function random($howMany)
	{
//		$value = array_rand($this->array, $howMany);
//		$arr = new self(is_array($value) ? $value : [$value]);
//		return $this->map
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
		return count($this->array);
	}

	public function current()
	{
		return current($this->array);
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
		return key($this->array);
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
		return next($this->array);
	}

	public function prev()
	{
		return prev($this->array);
	}

	public function reset()
	{
		return reset($this->array);
	}

	public function rsort()
	{
	}

	public function shuffle()
	{
		$copy = $this->array;
		shuffle($copy);
		return new self($copy);
	}

	public function sizeof()
	{
		return $this->count();
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

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid()
	{
		return key($this->array) !== null;
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		return $this->reset();
	}

	/**
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset)
	{
		return isset($this->array[$offset]);
	}

	/**
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset)
	{
		return $this->array[$offset] ?? null;
	}

	/**
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->array[] = $value;
		}
		else
		{
			$this->array[$offset] = $value;
		}
	}

	/**
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->array[$offset]);
	}
}