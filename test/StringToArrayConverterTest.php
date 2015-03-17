<?php

class StringToArrayConverterTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider invalidArgumentProvider
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConverterThrowsExceptionWhenInvalidArgumentGiven($argument)
	{
		$converterFactory = new StringToArrayConverterFactory($argument);
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
		$inputString    = 'a,b';
		$expectedOutput = array('a','b');

		$this->assertEquals($expectedOutput, $this->executeConversion($inputString));
	}

	public function testConverterReturnsWithExpectedArrayWhenStringGivenWithoutComma()
	{
		$inputString    = 'ab+&rQ0[';
		$expectedOutput = array('ab+&rQ0[');

		$this->assertEquals($expectedOutput, $this->executeConversion($inputString));
	}

	public function testConverterWithMultiLineString()
	{
		$inputString    = 'dsfGa01.d,2' . PHP_EOL . '01kljFkf!,!';
		$expectedOutput  = array(
			array('dsfGa01.d', '2'),
			array('01kljFkf!', '!')
		);

		$this->assertEquals($expectedOutput, $this->executeConversion($inputString));
	}

	/**
	 * @expectedException InvalidLabelUsageException
	 */
	public function testConverterThrowsExceptionWhenInvalidLabelUsage()
	{
		$inputString = StringToArrayConverterFactory::LABEL_MARKER . PHP_EOL;

		$this->executeConversion($inputString);
	}

	/**
	 * @expectedException LabelAndDataMismatchException
	 */
	public function testConverterThrowsExceptionWhenLabelAndDataCountDoesNotMatch()
	{
		$inputString = StringToArrayConverterFactory::LABEL_MARKER . PHP_EOL
			. 'Position,Team,Point' . PHP_EOL
			. '1,McLaren Mercedes' . PHP_EOL
			. '2,Scuderia Ferrari';

		$this->executeConversion($inputString);
	}

	public function testConverterWithCorrectLabelledMultiLineString()
	{
		$inputString = StringToArrayConverterFactory::LABEL_MARKER . PHP_EOL
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

		$labelledMultiLineDo = $this->executeConversion($inputString);

		$this->assertEquals($expectedLabels, $labelledMultiLineDo->getLabels());
		$this->assertEquals($expectedData, $labelledMultiLineDo->getData());
	}

	/**
	 * Execute a string conversion.
	 *
	 * @param $inputString   String to convert.
	 *
	 * @return array|LabelledMultiLineDo   Result of the conversion.
	 */
	private function executeConversion($inputString)
	{
		$converterFactory    = new StringToArrayConverterFactory($inputString);
		$converter           = $converterFactory->getConverter();

		return $converter->convert();
	}
}
