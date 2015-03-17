<?php

/**
 * Class of single line string converter.
 */
class SingleLineStringToArrayConverter extends StringToArrayConverterAbstract
{
	/**
	 * Convert a single line string to array.
	 *
	 * @return array   Array.
	 */
	public function convert()
	{
		return explode(self::INLINE_SEPARATOR, $this->string);
	}
} 