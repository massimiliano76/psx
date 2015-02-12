<?php
/*
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2010-2015 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Wsdl;

use DOMDocument;
use PSX\Http\Request;
use PSX\Http\Response;
use PSX\Loader\Context;
use PSX\Url;

/**
 * GeneratorTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
	public function testVersion1()
	{
		$endpoint        = 'http://127.0.0.1/foo/api';
		$targetNamespace = 'http://127.0.0.1/wsdl/1/foo/api';

		$generator = new Generator(Generator::VERSION_1, 'foo', $endpoint, $targetNamespace);

		$wsdl = $generator->generate($this->getView());
		$wsdl->formatOutput = true;

		$dom = new DOMDocument();
		$dom->loadXML($wsdl->saveXML());

		$result = $dom->schemaValidate(__DIR__ . '/wsdl1.xsd');

		$this->assertTrue($result);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidVersion()
	{
		$generator = new Generator(8, 'foo', 'http://127.0.0.1/foo/api', 'http://127.0.0.1/wsdl/1/foo/api');
		$generator->generate($this->getView());
	}

	protected function getView()
	{
		$request    = new Request(new Url('http://127.0.0.1/foo/api'), 'GET');
		$response   = new Response();

		getContainer()->set('test_case', $this);

		$controller = getContainer()->get('controller_factory')
			->getController('PSX\Controller\Foo\Application\TestSchemaApiController', $request, $response, new Context());

		getContainer()->set('test_case', null);

		return $controller->getDocumentation()->getView(1);
	}
}
