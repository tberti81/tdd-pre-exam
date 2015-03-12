<?php

class DummyClassTest extends PHPUnit_Framework_TestCase
{
	public function testDummyClass()
	{
		$dummyClass = new DummyClass();
		$this->assertTrue($dummyClass->isOk());
	}
}
