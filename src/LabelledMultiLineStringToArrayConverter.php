<?php

/**
 * Class of labelled multi line string converter.
 */
class LabelledMultiLineStringToArrayConverter extends StringToArrayConverterAbstract
{
	/**
	 * Convert a labelled multi line string to specific data object.
	 *
	 * @return LabelledMultiLineDo   Data object.
	 *
	 * @throws LabelAndDataMismatchException
	 */
	public function convert()
	{
		$lines = explode(PHP_EOL, $this->string);

		array_shift($lines);

		$labels = explode(self::INLINE_SEPARATOR, $lines[0]);
		$labelledMultiLineDo = new LabelledMultiLineDo();
		$labelledMultiLineDo->setLabels($labels);

		array_shift($lines);
		foreach ($lines as $line) {
			$dataRow = explode(self::INLINE_SEPARATOR, $line);
			if (count($dataRow) != count($labels))
			{
				throw new LabelAndDataMismatchException();
			}
			$labelledMultiLineDo->appendDataRow($dataRow);
		}

		return $labelledMultiLineDo;
	}
} 