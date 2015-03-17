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

	/**
	 * @expectedException LabelAndDataMismatchException
	 */
	public function testConverterThrowsExceptionWhenLabelAndDataCountDoesNotMatch()
	{
		$string = StringToArrayConverter::LABEL_MARKER . PHP_EOL
			. 'Position,Team,Point' . PHP_EOL
			. '1,McLaren Mercedes' . PHP_EOL
			. '2,Scuderia Ferrari';
		$converter = new StringToArrayConverter($string);
		$converter->convert();
	}

	public function testConverterWithCorrectLabelledMultiLineString()
	{
		$string = StringToArrayConverter::LABEL_MARKER . PHP_EOL
			. 'Position,Team,Point' . PHP_EOL
			. '1,McLaren Mercedes,43' . PHP_EOL
			. '2,Scuderia Ferrari,15';
		$expectedLabels = array(
			'labels' => array(
				'Position',
				'Team',
				'Point'
			)
		);
		$expectedData = array(
			'data' => array(
				array(
					'1',
					'McLaren Mercedes',
					'43'
				),
				array(
					'2',
					'Scuderia Ferrari',
					'15'
				)
			)
		);

		$converter           = new StringToArrayConverter($string);
		$labelledMultiLineDo = $converter->convert();

		$this->assertEquals($expectedLabels, $labelledMultiLineDo->getLabels());
		$this->assertEquals($expectedData, $labelledMultiLineDo->getData());
	}
}
