<?php
/*
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2010-2014 Christoph Kappestein <k42b3.x@gmail.com>
 *
 * This file is part of psx. psx is free software: you can
 * redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 *
 * psx is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with psx. If not, see <http://www.gnu.org/licenses/>.
 */

namespace PSX\Data\Schema\Property;

/**
 * StringTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
	public function testValidate()
	{
		$property = new String('test');

		$this->assertTrue($property->validate('foo'));
	}

	/**
	 * @expectedException PSX\Data\Schema\ValidationException
	 */
	public function testValidateInvalidFormat()
	{
		$property = new String('test');

		$this->assertTrue($property->validate(new \stdClass()));
	}

	public function testMinLength()
	{
		$property = new String('test');
		$property->setMinLength(3);

		$this->assertTrue($property->validate('foo'));
	}

	/**
	 * @expectedException PSX\Data\Schema\ValidationException
	 */
	public function testMinLengthInvalid()
	{
		$property = new String('test');
		$property->setMinLength(3);

		$this->assertTrue($property->validate('fo'));
	}

	public function testMaxLength()
	{
		$property = new String('test');
		$property->setMaxLength(3);

		$this->assertTrue($property->validate('foo'));
	}

	/**
	 * @expectedException PSX\Data\Schema\ValidationException
	 */
	public function testMaxLengthInvalid()
	{
		$property = new String('test');
		$property->setMaxLength(3);

		$this->assertTrue($property->validate('fooo'));
	}

	public function testPattern()
	{
		$property = new String('test');
		$property->setPattern('[A-z]+');

		$this->assertTrue($property->validate('foo'));
	}

	/**
	 * @expectedException PSX\Data\Schema\ValidationException
	 */
	public function testPatternInvalid()
	{
		$property = new String('test');
		$property->setPattern('[A-z]');

		$this->assertTrue($property->validate('123'));
	}
}