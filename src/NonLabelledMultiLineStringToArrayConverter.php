<?php

/**
 * Class of non-labelled multi line string converter.
 */
class NonLabelledMultiLineStringToArrayConverter extends StringToArrayConverterAbstract
{
	/**
	 * Convert a non-labelled multi line string to array.
	 *
	 * @return array   Array.
	 */
	public function convert()
	{
		$lines  = explode(PHP_EOL, $this->string);
		$result = array();
		foreach ($lines as $line)
		{
			$result[] = explode(self::INLINE_SEPARATOR, $line);
		}

		return $result;
	}
} 