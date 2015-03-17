<?php

/**
 * Factory class of string converter classes.
 */
class StringToArrayConverterFactory
{
	/** Label marker. */
	const LABEL_MARKER = '#useFirstLineAsLabels';

	/**
	 * String to convert.
	 *
	 * @var string
	 */
	private $string;

	/**
	 * Constructor.
	 *
	 * @param string $string   String to convert.
	 */
	public function __construct($string)
	{
		if (!$this->isValid($string))
		{
			throw new InvalidArgumentException();
		}

		$this->string = $string;
	}

	/**
	 * Get specific converter class for string conversion.
	 *
	 * @return LabelledMultiLineStringToArrayConverter|NonLabelledMultiLineStringToArrayConverter|SingleLineStringToArrayConverter
	 *
	 * @throws InvalidLabelUsageException
	 */
	public function getConverter()
	{
		if ($this->isMultiLine())
		{
			if ($this->hasLabelMarker())
			{
				if (!$this->isValidLabelUsage())
				{
					throw new InvalidLabelUsageException();
				}

				return new LabelledMultiLineStringToArrayConverter($this->string);
			}

			return new NonLabelledMultiLineStringToArrayConverter($this->string);
		}

		return new SingleLineStringToArrayConverter($this->string);
	}

	/**
	 * Decide whether an input of conversion is valid or not.
	 *
	 * @param mixed $input   Input of conversion.
	 *
	 * @return bool
	 */
	private function isValid($input)
	{
		return is_string($input);
	}

	/**
	 * Decide whether a string is multi lined or not.
	 *
	 * @return bool
	 */
	private function isMultiLine()
	{
		return strpos($this->string, PHP_EOL) !== false;
	}

	/**
	 * Decide whether a multi line string has label or not.
	 *
	 * @return bool
	 */
	private function hasLabelMarker()
	{
		return strpos($this->string, self::LABEL_MARKER) !== false;
	}

	/**
	 * Decide whether a labelled multi line string is valid or not.
	 *
	 * @return bool
	 */
	private function isValidLabelUsage()
	{
		return $this->hasLabelRow() && $this->hasDataRow();
	}

	/**
	 * Decide whether a labelled multi line string has a label row or not.
	 *
	 * @return bool
	 */
	private function hasLabelRow()
	{
		$lines = explode(PHP_EOL, $this->string);

		return !empty($lines[1]);
	}

	/**
	 * Decide whether a labelled multi line string has a data row or not.
	 *
	 * @return bool
	 */
	private function hasDataRow()
	{
		$lines = explode(PHP_EOL, $this->string);

		return count($lines) > 2;
	}
}