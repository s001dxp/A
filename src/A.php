<?php

namespace Sdxp;

class A implements \ArrayAccess, \Iterator, \Countable
{
	protected $array;

	public function __construct(array $array = [])
	{
		$this->array = $array;
	}

	public static function array(array $array = [])
	{
		return new self($array);
	}

	/**
	 * @param array|\ArrayAccess $array
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	private function convertArray(...$array)
	{
		$retVal = [];
		foreach($array as $val)
		{
			if(is_array($val))
			{
				$retVal[] = $array;
			}
			elseif($val instanceof A)
			{
				$retVal[] = $val->getArray();
			}
			else
			{
				throw new \InvalidArgumentException('convertArray function only accepts an array or an instance of A.');
			}
		}
		return $retVal;
	}

	public function getArray()
	{
		return $this->array;
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

	public function combineLeft($array)
	{
		$array = $this->convertArray($array);
		return new self(array_combine($array, $this->array));
	}

	public function combineRight($array)
	{
		$array = $this->convertArray($array);
		return new self(array_combine($this->array, $array));
	}

	public function countValues()
	{
		return new self(array_count_values($this->array));
	}

	public function diffAssoc($array, ...$otherArrays)
	{
		$array = $this->convertArray($array, ...$otherArrays);
		return new self(array_diff_assoc($this->array, ...$array));
	}

	public function diffKey($array, ...$otherArrays)
	{
		$array = $this->convertArray($array, ...$otherArrays);
		return new self(array_diff_key($this->array, ...$array));
	}

	public function diffUAssoc($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_diff_uassoc($this->array, $array, $callback));
	}

	public function diffUKey($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_diff_ukey($this->array, $array, $callback));
	}

	/**
	 * @param       $array
	 * @param array ...$otherArrays
	 * @return A
	 */
	public function diff($array, ...$otherArrays)
	{
		$array = $this->convertArray($array);
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

	public function intersectAssoc($array, ...$otherArrays)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_assoc($this->array, $array, ...$otherArrays));
	}

	public function intersectKey($array, ...$otherArrays)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_key($this->array, $array, ...$otherArrays));
	}

	public function intersectUAssoc($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_uassoc($this->array, $array, $callback));
	}

	public function intersectUKey($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_ukey($this->array, $array, $callback));
	}

	public function intersect($array, ...$otherArrays)
	{
		$array = $this->convertArray($array);
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

	public function mergeRecursive($array)
	{
		$array = $this->convertArray($array);
		return new self(array_merge_recursive($this->array, $array));
	}

	public function merge($array)
	{
		$array = $this->convertArray($array);
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
		$value = array_rand($this->array, $howMany);
		$arr = new self(is_array($value) ? $value : [$value]);
		return $arr->map(function($val){
			return $this[$val];
		});
	}

	public function reduce(callable $callback, $initial = null)
	{
		$reduced = array_reduce($this->array, $callback, $initial);
		return is_array($reduced) ? new self($reduced) : $reduced;
	}

	public function replaceRecursive($array, ...$moreArrays)
	{
		$array = $this->convertArray($array);
		return new self(array_replace_recursive($this->array, $array, ...$moreArrays));
	}

	public function replace($array, ...$moreArrays)
	{
		$array = $this->convertArray($array);
		return new self(array_replace($this->array, $array, ...$moreArrays));
	}

	public function reverse()
	{
		return new self(array_reverse($this->array));
	}

	public function search($needle)
	{
		return array_search($needle, $this->array);
	}

	public function shift()
	{

	}

	public function slice(int $offset, int $length = NULL, bool $preserve_keys = FALSE)
	{
		return new self(array_slice($this->array, $offset, $length, $preserve_keys));
	}

	public function splice(int $offset, int $length = null, $replacement = [])
	{
		$copy = $this->array;
		$length = $length ?? count($copy);
		array_splice($copy, $offset, $length, $replacement);
		return new self($copy);
	}

	public function sum()
	{
		return array_sum($this->array);
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

	public function unique(int $sort_flags = SORT_STRING)
	{
		return new self(array_unique($this->array, $sort_flags));
	}

	public function unshift(...$moreValues)
	{
		$copy = $this->array;
		array_unshift($copy, ...$moreValues);
		return new self($copy);
	}

	public function values()
	{
		return new self(array_values($this->array));
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

	public function count()
	{
		return count($this->array);
	}

	public function current()
	{
		return current($this->array);
	}

	public function forEach(callable $callback): void
	{
		foreach($this->array as $key => $value)
		{
			$callback($value, $key);
		}
	}

	public function end()
	{
	}

	public function extract()
	{
	}

	public function contains($value)
	{
		return in_array($value, $this->array);
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