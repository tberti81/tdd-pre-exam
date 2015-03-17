<?php

/**
 * Abstract class of string converter classes.
 */
abstract class StringToArrayConverterAbstract
{
	/** Inline separator. */
	const INLINE_SEPARATOR = ',';

	/**
	 * String to convert.
	 *
	 * @var string
	 */
	protected $string;

	/**
	 * Constructor.
	 *
	 * @param string $string   String to convert.
	 */
	public function __construct($string)
	{
		$this->string = $string;
	}

	/**
	 * Abstract converter method.
	 *
	 * @return mixed
	 */
	abstract public function convert();
}
