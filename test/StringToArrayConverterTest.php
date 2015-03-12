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
		$converter = new StringToArrayConverter();
		$converter->convert($param);
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
}
