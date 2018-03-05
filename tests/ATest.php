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
/*
	public function testChunk()
	{

	}

	public function testColumn()
	{

	}

	public function testCombineLeft()
	{

	}

	public function testCombineRight()
	{

	}

	public function testCountValues()
	{

	}

	public function testDiffAssoc()
	{

	}

	public function testDiffKey()
	{

	}

	public function testDiffUAssoc()
	{

	}

	public function testDiffUKey()
	{

	}

	public function testDiff()
	{

	}

	public function testFilter()
	{

	}

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

	public function testIntersect()
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
