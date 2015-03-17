<?php

class StringToArrayConverter
{
	const LABEL_MARKER = '#useFirstLineAsLabels';

	private $string;

	public function __construct($string)
	{
		if (!$this->isValid($string))
		{
			throw new InvalidArgumentException();
		}

		$this->string = $string;
	}

	public function convert()
	{
		if ($this->isMultiLine())
		{
			if ($this->hasLabelMarker())
			{
				if (!$this->isValidLabelUsage())
				{
					throw new InvalidLabelUsageException();
				}

				return $this->convertLabelledMultiLine();
			}

			return $this->convertMultiLine();
		}

		return $this->convertSingleLine();
	}

	private function isValid($string)
	{
		return is_string($string);
	}

	private function convertSingleLine()
	{
		return explode(',', $this->string);
	}

	private function isMultiLine()
	{
		return strpos($this->string, PHP_EOL) !== false;
	}

	private function convertMultiLine()
	{
		$lines  = explode(PHP_EOL, $this->string);
		$result = array();
		foreach ($lines as $line)
		{
			$result[] = explode(',', $line);
		}

		return $result;
	}

	private function hasLabelMarker()
	{
		return strpos($this->string, self::LABEL_MARKER) !== false;
	}

	private function isValidLabelUsage()
	{
		return $this->hasLabelRow() && $this->hasDataRow();
	}

	private function hasLabelRow()
	{
		$lines = explode(PHP_EOL, $this->string);

		return !empty($lines[1]);
	}

	private function hasDataRow()
	{
		$lines = explode(PHP_EOL, $this->string);

		return count($lines) > 2;
	}

	private function convertLabelledMultiLine()
	{
		throw new LabelAndDataMismatchException();
	}
}
