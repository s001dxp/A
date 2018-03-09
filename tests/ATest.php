<?php
namespace Sdxp;

use PHPUnit\Framework\TestCase;
use Sdxp\A;

class ATest extends TestCase
{

	public function numberedArrayProvider()
	{
		return ['a', 'b', 'c', 'd', 'e', 'f'];
	}

	public function numberedArray2Provider()
	{
		return ['a', 'b', 'c', 'x', 'y', 'z'];
	}

	public function assocArrayProvider()
	{
		return ['a' => 'Neo', 'b' => 'Morpheus', 'c' => 'Trinity', 'd' => 'Smith', 'e' => 'Cypher', 'f' => 'Persephone'];
	}

	public function assocMultiDimArrayProvider()
	{
		return [
			['a' => 'Neo', 'b' => 'Morpheus', 'c' => 'Trinity', 'd' => 'Smith', 'e' => 'Cypher', 'f' => 'Persephone'],
			['a' => 'Neo', 'b' => 'Morpheus', 'c' => 'Trinity', 'd' => 'Smith', 'e' => 'Cypher', 'f' => 'Persephone'],
			['a' => 'Neo', 'b' => 'Morpheus', 'c' => 'Trinity', 'd' => 'Smith', 'e' => 'Cypher', 'f' => 'Persephone'],
			['a' => 'Neo', 'b' => 'Morpheus', 'c' => 'Trinity', 'd' => 'Smith', 'e' => 'Cypher', 'f' => 'Persephone'],
		];
	}

	public function getAObjectAssoc()
	{
		return A::array($this->assocArrayProvider());
	}

	public function getAObjectMultiAssoc()
	{
		return A::array($this->assocMultiDimArrayProvider());
	}

	public function getAObjectNumerical()
	{
		return A::array($this->numberedArrayProvider());
	}

	public function testConstructWithNumericalArray()
	{
		$a = new A($this->numberedArrayProvider());
		$this->assertInstanceOf('Sdxp\A', $a);

		$this->assertEquals($this->numberedArrayProvider(), $a->getArray());
	}

	public function testConstructWithAssocArray()
	{
		$a = new A($this->assocArrayProvider());
		$this->assertInstanceOf('Sdxp\A', $a);

		$this->assertEquals($this->assocArrayProvider(), $a->getArray());
	}

	public function testConstructWithOutArray()
	{
		$a = new A();
		$this->assertInstanceOf('Sdxp\A', $a);

		$this->assertEquals([], $a->getArray());
	}

	public function testArray()
	{
		$a = A::array($this->numberedArrayProvider());
		$this->assertInstanceOf('Sdxp\A', $a);
	}

	public function testChangeKeyCase()
	{
		$a = $this->getAObjectAssoc();

		$b = $a->changeKeyCase(\CASE_UPPER);
		$this->assertNotEquals(\array_keys($b->getArray()), \array_keys($this->assocArrayProvider()));

		$c = $b->changeKeyCase();
		$this->assertEquals(\array_keys($c->getArray()), \array_keys($this->assocArrayProvider()));
	}

	public function testChunk()
	{
		$a = $this->getAObjectNumerical();
		$b = $a->chunk(2);

		$arr = $this->numberedArrayProvider();
		$i = 0;
		$this->assertCount(3, $b->getArray());
		$b->forEach(function(A $v) use ($arr, &$i) {
			$this->assertCount(2, $v->getArray());

			$v->forEach(function($v) use ($arr, &$i) {
				$this->assertEquals($arr[$i], $v);
				$i++;
			});
		});

	}

	public function testColumn()
	{
		$a = $this->getAObjectMultiAssoc();
		$b = $a->column('b');

		$this->assertCount(4, $b);
		$b->forEach(function($v){
			$this->assertEquals('Morpheus', $v);
		});

		$this->assertEquals(4, $a->column('b')->count());
	}

	public function testCombineLeft()
	{
		$a = $this->getAObjectNumerical();
		$b = $this->getAObjectAssoc();
		$c = $a->combineLeft($b);

		$this->assertEquals(
			\array_combine(
				\array_values($this->assocArrayProvider()),
				\array_values($this->numberedArrayProvider())
			),
			$c->getArray()
		);
	}

	public function testCombineRight()
	{
		$a = $this->getAObjectAssoc();
		$b = $this->getAObjectNumerical();
		$c = $a->combineRight($b);

		$this->assertEquals(
			\array_combine(
				\array_values($this->assocArrayProvider()),
				\array_values($this->numberedArrayProvider())
			),
			$c->getArray()
		);
	}

	public function testDiff()
	{
		$a = $this->getAObjectNumerical();
		$b = A::array($this->numberedArray2Provider());

		$c = $a->diff($b);
		$this->assertEquals(\array_values(['d','e','f']), \array_values($c->getArray()));

		$d = $a->diff($this->numberedArray2Provider());
		$this->assertEquals(\array_values(['d','e','f']), \array_values($d->getArray()));

		$e = A::array(['f']);
		$f = $a->diff($b, $e);
		$this->assertEquals(\array_values(['d','e']), \array_values($f->getArray()));

		$h = $a->diff($b, ['f']);
		$this->assertEquals(\array_values(['d','e']), \array_values($h->getArray()));
	}

	public function testIntersect()
	{
		$a = $this->getAObjectNumerical();
		$b = A::array($this->numberedArray2Provider());

		$c = $a->intersect($b);
		$this->assertEquals(\array_values(['a','b','c']), \array_values($c->getArray()));

		$d = $a->intersect($this->numberedArray2Provider());
		$this->assertEquals(\array_values(['a','b','c']), \array_values($d->getArray()));

		$e = A::array(['f']);
		$f = $a->intersect($b, $e);
		$this->assertEquals(\array_values([]), \array_values($f->getArray()));

		$h = $a->intersect($b, ['b']);
		$this->assertEquals(\array_values(['b']), \array_values($h->getArray()));
	}

	public function testAIterator()
	{
		$a = $this->getAObjectAssoc();
		$b = $this->assocArrayProvider();

		$c = [];
		foreach($a as $key => $val)
		{
			$c[$key] = $val;
		}
		$this->assertEquals($b, $c);
	}

	public function testArrayAccess()
	{
		$a = $this->getAObjectAssoc();
		$c = $this->assocArrayProvider();
		$c['g'] = 'The Oracle';
		$a['g'] = 'The Oracle';
		$this->assertEquals($c, $a->getArray());
		$this->assertEquals('Neo', $a['a']);

		$b = $this->getAObjectNumerical();
		$d = $this->numberedArrayProvider();
		$d[] = 'g';
		$b[] = 'g';
		$this->assertEquals($d, $b->getArray());
		$this->assertEquals('a', $b[0]);
	}

	public function testFilter()
	{
		$a = $this->getAObjectAssoc();
		$b = $a->filter(function($val, $key){
			return $val === 'Cypher';
		});
		$this->assertEquals(['e' => 'Cypher'], $b->getArray());

		$c = $a->filter(function($val, $key){
			return $key === 'a';
		});
		$this->assertEquals(['a' => 'Neo'], $c->getArray());
	}
/*
	public function testFlip()
	{

	}

	public function testIntersectAssoc()
	{

	}

	public function testIntersectKey()
	{

	}

	public function testIntersectUAssoc()
	{

	}

	public function testIntersectUKey()
	{

	}


	public function testKeyExists()
	{

	}

	public function testHas()
	{

	}

	public function testKeys()
	{

	}

	public function testMap()
	{

	}

	public function testMergeRecursive()
	{

	}

	public function testMerge()
	{

	}

	public function testProduct()
	{

	}

	public function testPush()
	{

	}

	public function testRandom()
	{

	}

	public function testReduce()
	{

	}

	public function testReplace()
	{

	}

	public function testReverse()
	{

	}

	public function testSearch()
	{

	}

	public function testShift()
	{

	}

	public function testSlice()
	{

	}

	public function testSplice()
	{

	}

	public function testSum()
	{

	}

	public function testUnique()
	{

	}

	public function testValues()
	{

	}

	public function testCount()
	{

	}

	public function testForEach()
	{

	}

	public function testContains()
	{

	}

	public function testShuffle()
	{

	}*/

	/**
	 * Call protected/private method of a class.
	 *
	 * @param object &$object Instantiated object that we will run method on.
	 * @param string $methodName Method name to call
	 * @param array  $parameters Array of parameters to pass into method.
	 *
	 * @return mixed Method return.
	 * @throws \ReflectionException
	 */
	public function invokeMethod(&$object, $methodName, array $parameters = array())
	{
		$reflection = new \ReflectionClass(get_class($object));
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs($object, $parameters);
	}

}
