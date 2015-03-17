<?php

class LabelledMultiLineDo
{
	/**
	 * Labels.
	 *
	 * @var array
	 */
	private $labels;

	/**
	 * Data.
	 *
	 * @var array
	 */
	private $data;

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data = array('data' => $data);
	}

	/**
	 * @param array $data
	 */
	public function appendDataRow(array $data)
	{
		$this->data['data'][] = $data;
	}

	/**
	 * @return array
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	/**
	 * @param array $labels
	 */
	public function setLabels(array $labels)
	{
		$this->labels = array('labels' => $labels);
	}


}