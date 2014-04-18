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

namespace PSX\Data;

/**
 * WriterFactoryTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3
 * @link    http://phpsx.org
 */
class WriterFactoryTest extends \PHPUnit_Framework_TestCase
{
	protected $writerFactory;

	public function setUp()
	{
		$template = $this->getMockBuilder('PSX\TemplateInterface')
			->getMock();

		$reverseRouter = $this->getMockBuilder('PSX\Loader\ReverseRouter')
			->disableOriginalConstructor()
			->getMock();

		$this->writerFactory = new WriterFactory();
		$this->writerFactory->addWriter(new Writer\Json());
		$this->writerFactory->addWriter(new Writer\Html($template, $reverseRouter));
		$this->writerFactory->addWriter(new Writer\Atom());
		$this->writerFactory->addWriter(new Writer\Form());
		$this->writerFactory->addWriter(new Writer\Jsonp());
		$this->writerFactory->addWriter(new Writer\Rss());
		$this->writerFactory->addWriter(new Writer\Xml());
	}

	public function testGetDefaultWriter()
	{
		$this->assertInstanceOf('PSX\Data\Writer\Json', $this->writerFactory->getDefaultWriter());
	}

	public function testGetWriterByContentType()
	{
		$this->assertInstanceOf('PSX\Data\Writer\Json', $this->writerFactory->getWriterByContentType('application/json'));
		$this->assertInstanceOf('PSX\Data\Writer\Html', $this->writerFactory->getWriterByContentType('text/html'));
		$this->assertInstanceOf('PSX\Data\Writer\Atom', $this->writerFactory->getWriterByContentType('application/atom+xml'));
		$this->assertInstanceOf('PSX\Data\Writer\Form', $this->writerFactory->getWriterByContentType('application/x-www-form-urlencoded'));
		$this->assertInstanceOf('PSX\Data\Writer\Jsonp', $this->writerFactory->getWriterByContentType('application/javascript'));
		$this->assertInstanceOf('PSX\Data\Writer\Rss', $this->writerFactory->getWriterByContentType('application/rss+xml'));
		$this->assertInstanceOf('PSX\Data\Writer\Xml', $this->writerFactory->getWriterByContentType('application/xml'));
	}

	public function testGetWriterByContentTypeSupportedWriter()
	{
		$contentType = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';

		$this->assertInstanceOf('PSX\Data\Writer\Html', $this->writerFactory->getWriterByContentType($contentType));
		$this->assertInstanceOf('PSX\Data\Writer\Html', $this->writerFactory->getWriterByContentType($contentType, array('PSX\Data\Writer\Html')));
		$this->assertInstanceOf('PSX\Data\Writer\Xml', $this->writerFactory->getWriterByContentType($contentType, array('PSX\Data\Writer\Xml')));
		$this->assertEquals(null, $this->writerFactory->getWriterByContentType($contentType, array('PSX\Data\Writer\Json')));
	}

	public function testGetWriterByContentTypeOrder()
	{
		$supportedWriter = array('PSX\Data\Writer\Html', 'PSX\Data\Writer\Xml');

		$contentType = 'application/json,text/html,application/xml';

		$this->assertInstanceOf('PSX\Data\Writer\Html', $this->writerFactory->getWriterByContentType($contentType, $supportedWriter));

		$contentType = 'application/json,application/xml,text/html';

		$this->assertInstanceOf('PSX\Data\Writer\Xml', $this->writerFactory->getWriterByContentType($contentType, $supportedWriter));
	}

	public function testGetWriterByInstance()
	{
		$this->assertInstanceOf('PSX\Data\Writer\Json', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Json'));
		$this->assertInstanceOf('PSX\Data\Writer\Html', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Html'));
		$this->assertInstanceOf('PSX\Data\Writer\Atom', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Atom'));
		$this->assertInstanceOf('PSX\Data\Writer\Form', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Form'));
		$this->assertInstanceOf('PSX\Data\Writer\Jsonp', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Jsonp'));
		$this->assertInstanceOf('PSX\Data\Writer\Rss', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Rss'));
		$this->assertInstanceOf('PSX\Data\Writer\Xml', $this->writerFactory->getWriterByInstance('PSX\Data\Writer\Xml'));		
	}

	public function testGetContentTypeByFormat()
	{
		$this->assertEquals('application/json', $this->writerFactory->getContentTypeByFormat('json'));
		$this->assertEquals('text/html', $this->writerFactory->getContentTypeByFormat('html'));
		$this->assertEquals('application/atom+xml', $this->writerFactory->getContentTypeByFormat('atom'));
		$this->assertEquals('application/x-www-form-urlencoded', $this->writerFactory->getContentTypeByFormat('form'));
		$this->assertEquals('application/javascript', $this->writerFactory->getContentTypeByFormat('jsonp'));
		$this->assertEquals('application/rss+xml', $this->writerFactory->getContentTypeByFormat('rss'));
		$this->assertEquals('application/xml', $this->writerFactory->getContentTypeByFormat('xml'));	
	}
}