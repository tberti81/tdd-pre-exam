<?php

class StringToArrayConverter
{
	public function convert($string)
	{
		if (!is_string($string))
		{
			throw new InvalidArgumentException();
		}
	}
}
