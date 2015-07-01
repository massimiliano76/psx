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

namespace PSX\Controller;

use PSX\Data\Record;
use PSX\Data\Writer;
use PSX\Test\ControllerTestCase;

/**
 * ApiAbstractTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ApiAbstractTest extends ControllerTestCase
{
    public function testSetResponse()
    {
        $response = $this->sendRequest('http://127.0.0.1/api', 'GET');
        $body     = (string) $response->getBody();

        $this->assertEquals(null, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString(json_encode(array('bar' => 'foo')), $body, $body);
    }

    public function testImport()
    {
        $response = $this->sendRequest('http://127.0.0.1/api/insert', 'POST', ['Content-Type' => 'application/json'], json_encode(['title' => 'foo', 'user' => 'bar']));
        $body     = (string) $response->getBody();

        $this->assertEquals(null, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString(json_encode(array('title' => 'foo', 'user' => 'bar')), $body);
    }

    public function testInnerApi()
    {
        $response = $this->sendRequest('http://127.0.0.1/api/inspect?format=json&fields=foo,bar&updatedSince=2014-01-26&count=8&filterBy=id&filterOp=equals&filterValue=12&sortBy=id&sortOrder=desc&startIndex=4', 'GET');
        $body     = (string) $response->getBody();

        $this->assertEquals(null, $response->getStatusCode(), $body);
    }

    protected function getPaths()
    {
        return array(
            [['GET'], '/api', 'PSX\Controller\Foo\Application\TestApiController::doIndex'],
            [['POST'], '/api/insert', 'PSX\Controller\Foo\Application\TestApiController::doInsert'],
            [['GET'], '/api/inspect', 'PSX\Controller\Foo\Application\TestApiController::doInspect'],
        );
    }
}
