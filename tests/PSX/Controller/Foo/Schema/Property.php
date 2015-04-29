<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2015 Christoph Kappestein <k42b3.x@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Controller\Foo\Schema;

use PSX\Data\SchemaAbstract;
use PSX\Data\Schema\Property as SchemaProperty;

/**
 * Property
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Property extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('complex');
		$sb->string('foo');
		$complex = $sb->getProperty();

		$sb = $this->getSchemaBuilder('property');
		$sb->arrayType('array')->setPrototype(new SchemaProperty\String('foo'));
		$sb->boolean('boolean');
		$sb->complexType($complex);
		$sb->date('date');
		$sb->dateTime('dateTime');
		$sb->duration('duration');
		$sb->float('float');
		$sb->integer('integer');
		$sb->string('string');
		$sb->time('time');

		return $sb->getProperty();
	}
}