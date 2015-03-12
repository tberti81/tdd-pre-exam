<?php

class StringToArrayConverter
{
	public function convert($string)
	{
		if (!$this->isValid($string))
		{
			throw new InvalidArgumentException();
		}

		if ($this->isMultiLine($string))
		{
			return $this->convertMultiLine($string);
		}

		return $this->convertSingleLine($string);
	}

	private function isValid($string)
	{
		return is_string($string);
	}

	private function convertSingleLine($string)
	{
		return explode(',', $string);
	}

	private function isMultiLine($string)
	{
		return strpos($string, PHP_EOL) !== false;
	}

	private function convertMultiLine($string)
	{
		$lines  = explode(PHP_EOL, $string);
		$result = array();
		foreach ($lines as $line)
		{
			$result[] = explode(',', $line);
		}

		return $result;
	}
}
