<?php
/*
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2010-2013 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Module;

use PSX\Data\Writer;
use PSX\Data\WriterInterface;
use PSX\Data\Record;
use PSX\Loader\Location;
use ReflectionClass;

/**
 * ApiAbstractTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
class ApiAbstractTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
	}

	protected function tearDown()
	{
	}

	public function testSetResponse()
	{
		// add sepcial writer wich has no content type so no header is sent in
		// setResponse
		getContainer()->get('writerFactory')->addWriter(new NoContentTypeJsonWriter());

		$record = new Record('foo', array('bar' => 'foo'));
		$module = $this->getModule();

		ob_start();

		$module->callMethod('setResponse', array($record, 'PSX\Module\NoContentTypeJsonWriter', null));

		$contents = ob_get_contents();
		ob_end_clean();

		$this->assertJsonStringEqualsJsonString($contents, json_encode(array('bar' => 'foo')));
	}

	protected function getModule()
	{
		$container    = getContainer();
		$location     = new Location('foo', '', new ReflectionClass('PSX\Module\TestApiModule'));
		$basePath     = '';
		$uriFragments = array();

		return new TestApiModule($container, $location, $basePath, $uriFragments);
	}
}

class NoContentTypeJsonWriter extends Writer\Json
{
	public function getContentType()
	{
		return null;
	}
}
