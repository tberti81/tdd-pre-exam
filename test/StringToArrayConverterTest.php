<?php

class StringToArrayConverterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider invalidArgumentProvider
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConverterThrowsExceptionWhenInvalidArgumentGiven($param)
	{
		$converter = new StringToArrayConverter($param);
		$converter->convert();
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
		$converter = new StringToArrayConverter('a,b');
		$this->assertEquals(array('a','b'), $converter->convert());
	}

	public function testConverterReturnsWithExpectedArrayWhenStringGivenWithoutComma()
	{
		$converter = new StringToArrayConverter('ab+&rQ0[');
		$this->assertEquals(array('ab+&rQ0['), $converter->convert());
	}

	public function testConverterWithMultiLineString()
	{
		$multiLineString = 'dsfGa01.d,2' . PHP_EOL . '01kljFkf!,!';
		$converter = new StringToArrayConverter($multiLineString);
		$expectedOutput  = array(
			array('dsfGa01.d', '2'),
			array('01kljFkf!', '!')
		);
		$this->assertEquals($expectedOutput, $converter->convert());
	}

	/**
	 * @expectedException InvalidLabelUsageException
	 */
	public function testConverterThrowsExceptionWhenInvalidLabelUsage()
	{
		$string = StringToArrayConverter::LABEL_MARKER . PHP_EOL;
		$converter = new StringToArrayConverter($string);
		$converter->convert();
	}
}
