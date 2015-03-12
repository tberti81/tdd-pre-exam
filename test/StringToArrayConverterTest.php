<?php

class StringToArrayConverterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var StringToArrayConverter
	 */
	private $converter;

	public function setUp()
	{
		$this->converter = new StringToArrayConverter();
	}

	/**
	 * @dataProvider invalidArgumentProvider
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConverterThrowsExceptionWhenInvalidArgumentGiven($param)
	{
		$this->converter = new StringToArrayConverter();
		$this->converter->convert($param);
	}

	public function invalidArgumentProvider()
	{
		return array(
			array(0),
			array(new stdClass()),
			array(array()),
			array(true),
			array(null)
		);
	}

	public function testConverterReturnsWithExpectedArrayWhenCommaSeparatedStringGiven()
	{
		$this->assertEquals(array('a','b'), $this->converter->convert('a,b'));
	}

	public function testConverterReturnsWithExpectedArrayWhenStringGivenWithoutComma()
	{
		$this->assertEquals(array('ab+&rQ0['), $this->converter->convert('ab+&rQ0['));
	}
}
