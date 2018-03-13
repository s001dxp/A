<?php

namespace Sdxp;

/**
 * Class A
 * @package Sdxp
 */
class A implements \ArrayAccess, \Iterator, \Countable
{
	/**
	 * @var array
	 */
	protected $array;

	/**
	 * A constructor.
	 * @param array $array
	 */
	public function __construct(array $array = [])
	{
		$this->array = $array;
	}

	/**
	 * @param array $array
	 * @return A
	 */
	public static function array(array $array = [])
	{
		return new self($array);
	}

	/**
	 * @param array|\ArrayAccess $array
	 * @param bool               $wantArray
	 * @param array|\ArrayAccess $moreArrays
	 * @return array
	 */
	private function convertArray($array, $wantArray = false, ...$moreArrays)
	{
		//$returnArray = (empty($moreArrays)) ? false : true;
		if(is_bool($wantArray))
		{
			$returnArray = $wantArray === true;
		}
		else
		{
			array_unshift($moreArrays, $wantArray);
		}
		array_unshift($moreArrays, $array);
		$retVal = [];
		foreach($moreArrays as $val)
		{
			if(is_array($val))
			{
				$retVal[] = $val;
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
		return ($returnArray) ? $retVal : $retVal[0];
	}

	/**
	 * @return array
	 */
	public function getArray()
	{
		return $this->array;
	}

	/**
	 * @param int $case
	 * @return A
	 */
	public function changeKeyCase($case = CASE_LOWER)
	{
		return new self(array_change_key_case($this->array, $case));
	}

	/**
	 * @param      $size
	 * @param bool $preserve_keys
	 * @return A
	 */
	public function chunk($size, $preserve_keys = false)
	{
		return new self(array_map(function ($value) {
			return new A($value);
		}, array_chunk($this->array, $size, $preserve_keys)));
	}

	/**
	 * @param $column
	 * @return A
	 */
	public function column($column)
	{
		return new self(array_column($this->array, $column));
	}

	/**
	 * @param $array
	 * @return A
	 */
	public function combineLeft($array)
	{
		$array = $this->convertArray($array);
		return new self(array_combine($array, $this->array));
	}

	/**
	 * @param $array
	 * @return A
	 */
	public function combineRight($array)
	{
		$array = $this->convertArray($array);
		return new self(array_combine($this->array, $array));
	}

	/**
	 * @return A
	 */
	public function countValues()
	{
		return new self(array_count_values($this->array));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function diffAssoc($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_diff_assoc($this->array, ...$array));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function diffKey($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, ...$moreArrays);
		return new self(array_diff_key($this->array, ...$array));
	}

	/**
	 * @param          $array
	 * @param callable $callback
	 * @return A
	 */
	public function diffUAssoc($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_diff_uassoc($this->array, $array, $callback));
	}

	/**
	 * @param          $array
	 * @param callable $callback
	 * @return A
	 */
	public function diffUKey($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_diff_ukey($this->array, $array, $callback));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function diff($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_diff($this->array, ...$array));
	}

	/**
	 * @param callable $callback
	 * @return A
	 */
	public function filter(callable $callback)
	{
		return new self(array_filter($this->array, $callback, ARRAY_FILTER_USE_BOTH));
	}

	/**
	 * @return mixed
	 */
	public function first()
	{
		$a = array_reverse($this->array);
		return array_pop($a);
	}

	/**
	 * @return A
	 */
	public function flip()
	{
		return new self(array_flip($this->array));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function intersectAssoc($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_intersect_assoc($this->array, ...$array));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function intersectKey($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_intersect_key($this->array, ...$array));
	}

	/**
	 * @param          $array
	 * @param callable $callback
	 * @return A
	 */
	public function intersectUAssoc($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_uassoc($this->array, $array, $callback));
	}

	/**
	 * @param          $array
	 * @param callable $callback
	 * @return A
	 */
	public function intersectUKey($array, callable $callback)
	{
		$array = $this->convertArray($array);
		return new self(array_intersect_ukey($this->array, $array, $callback));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function intersect($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_intersect($this->array, ...$array));
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function keyExists($key)
	{
		return array_key_exists($key, $this->array);
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function has($key)
	{
		return $this->keyExists($key);
	}

	/**
	 * @return A
	 */
	public function keys()
	{
		return new self(array_keys($this->array));
	}

	/**
	 * @return mixed
	 */
	public function last()
	{
		return array_values(array_slice($this->array, -1))[0];
	}

	/**
	 * @param callable $callback
	 * @return A
	 */
	public function map(callable $callback)
	{
		return new self(array_map($callback, $this->array));
	}

	/**
	 * @param $array
	 * @return A
	 */
	public function mergeRecursive($array)
	{
		$array = $this->convertArray($array);
		return new self(array_merge_recursive($this->array, $array));
	}

	/**
	 * @param $array
	 * @return A
	 */
	public function merge($array)
	{
		$array = $this->convertArray($array);
		return new self(array_merge($this->array, $array));
	}

	/**
	 * @param int $size
	 * @param     $padding
	 * @return A
	 */
	public function pad(int $size, $padding)
	{
		return new self(array_pad($this->array, $size, $padding));
	}

	/**
	 *
	 */
	public function pop()
	{
	}

	/**
	 * @return float|int
	 */
	public function product()
	{
		return array_product($this->array);
	}

	/**
	 * @param       $value
	 * @param array ...$moreValues
	 * @return A
	 */
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

	/**
	 * @param $howMany
	 * @return A
	 */
	public function random($howMany)
	{
		$value = array_rand($this->array, $howMany);
		$arr = new self(is_array($value) ? $value : [$value]);
		return $arr->map(function($val){
			return $this[$val];
		});
	}

	/**
	 * @param callable $callback
	 * @param null     $initial
	 * @return mixed|A
	 */
	public function reduce(callable $callback, $initial = null)
	{
		$reduced = array_reduce($this->array, $callback, $initial);
		return is_array($reduced) ? new self($reduced) : $reduced;
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function replaceRecursive($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_replace_recursive($this->array, ...$array));
	}

	/**
	 * @param       $array
	 * @param array ...$moreArrays
	 * @return A
	 */
	public function replace($array, ...$moreArrays)
	{
		$array = $this->convertArray($array, true, ...$moreArrays);
		return new self(array_replace($this->array, ...$array));
	}

	/**
	 * @return A
	 */
	public function reverse()
	{
		return new self(array_reverse($this->array));
	}

	/**
	 * @param $needle
	 * @return false|int|string
	 */
	public function search($needle)
	{
		return array_search($needle, $this->array);
	}

	/**
	 *
	 */
	public function shift()
	{

	}

	/**
	 * @param int      $offset
	 * @param int|null $length
	 * @param bool     $preserve_keys
	 * @return A
	 */
	public function slice(int $offset, int $length = NULL, bool $preserve_keys = FALSE)
	{
		return new self(array_slice($this->array, $offset, $length, $preserve_keys));
	}

	/**
	 * @param int      $offset
	 * @param int|null $length
	 * @param array    $replacement
	 * @return A
	 */
	public function splice(int $offset, int $length = null, $replacement = [])
	{
		$copy = $this->array;
		$length = $length ?? count($copy);
		array_splice($copy, $offset, $length, $replacement);
		return new self($copy);
	}

	/**
	 * @return float|int
	 */
	public function sum()
	{
		return array_sum($this->array);
	}

	/**
	 *
	 */
	public function udiffAssoc()
	{
	}

	/**
	 *
	 */
	public function udiffUassoc()
	{
	}

	/**
	 *
	 */
	public function udiff()
	{
	}

	/**
	 *
	 */
	public function uintersectAssoc()
	{
	}

	/**
	 *
	 */
	public function uintersectUassoc()
	{
	}

	/**
	 *
	 */
	public function uintersect()
	{
	}

	/**
	 * @param int $sort_flags
	 * @return A
	 */
	public function unique(int $sort_flags = SORT_STRING)
	{
		return new self(array_unique($this->array, $sort_flags));
	}

	/**
	 * @param array ...$moreValues
	 * @return A
	 */
	public function unshift(...$moreValues)
	{
		$copy = $this->array;
		array_unshift($copy, ...$moreValues);
		return new self($copy);
	}

	/**
	 * @return A
	 */
	public function values()
	{
		return new self(array_values($this->array));
	}

	/**
	 *
	 */
	public function walkRecursive()
	{
	}

	/**
	 *
	 */
	public function walk()
	{
	}

	/**
	 *
	 */
	public function arsort()
	{
	}

	/**
	 *
	 */
	public function asort()
	{
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->array);
	}

	/**
	 * @return mixed
	 */
	public function current()
	{
		return current($this->array);
	}

	/**
	 * @param callable $callback
	 */
	public function forEach(callable $callback): void
	{
		foreach($this->array as $key => $value)
		{
			$callback($value, $key);
		}
	}

	/**
	 *
	 */
	public function end()
	{
	}

	/**
	 *
	 */
	public function extract()
	{
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function contains($value)
	{
		return in_array($value, $this->array);
	}

	/**
	 * @return int|mixed|null|string
	 */
	public function key()
	{
		return key($this->array);
	}

	/**
	 *
	 */
	public function krsort()
	{
	}

	/**
	 *
	 */
	public function ksort()
	{
	}

	/**
	 *
	 */
	public function list()
	{
	}

	/**
	 *
	 */
	public function natcasesort()
	{
	}

	/**
	 *
	 */
	public function natsort()
	{
	}

	/**
	 * @return mixed|void
	 */
	public function next()
	{
		return next($this->array);
	}

	/**
	 * @return mixed
	 */
	public function prev()
	{
		return prev($this->array);
	}

	/**
	 * @return mixed
	 */
	public function reset()
	{
		return reset($this->array);
	}

	/**
	 *
	 */
	public function rsort()
	{
	}

	/**
	 * @return A
	 */
	public function shuffle()
	{
		$copy = $this->array;
		shuffle($copy);
		return new self($copy);
	}

	/**
	 * @return int
	 */
	public function sizeof()
	{
		return $this->count();
	}

	/**
	 *
	 */
	public function sort()
	{
	}

	/**
	 *
	 */
	public function uasort()
	{
	}

	/**
	 *
	 */
	public function uksort()
	{
	}

	/**
	 *
	 */
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
		$this->reset();
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