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

namespace PSX\Api\Resource\Generator;

/**
 * RamlTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class RamlTest extends GeneratorTestCase
{
	public function testGenerate()
	{
		$generator = new Raml('foobar', 1, 'http://api.phpsx.org', 'urn:schema.phpsx.org#');
		$raml      = $generator->generate($this->getResource());

		$expect = <<<'RAML'
#%RAML 0.8
---
baseUri: http://api.phpsx.org
version: v1
title: foobar
/foo/bar:
  get:
    responses:
      200:
        body:
          application/json:
            schema: |
              {
                  "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
                  "id": "urn:schema.phpsx.org#",
                  "type": "object",
                  "definitions": {
                      "ref7738db4616810154ab42db61b65f74aa": {
                          "type": "object",
                          "properties": {
                              "id": {
                                  "type": "integer"
                              },
                              "userId": {
                                  "type": "integer"
                              },
                              "title": {
                                  "type": "string",
                                  "minLength": 3,
                                  "maxLength": 16,
                                  "pattern": "[A-z]+"
                              },
                              "date": {
                                  "type": "string"
                              }
                          },
                          "additionalProperties": false
                      }
                  },
                  "properties": {
                      "entry": {
                          "type": "array",
                          "items": {
                              "$ref": "#\/definitions\/ref7738db4616810154ab42db61b65f74aa"
                          }
                      }
                  },
                  "additionalProperties": false
              }
  post:
    body:
      application/json:
        schema: |
          {
              "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
              "id": "urn:schema.phpsx.org#",
              "type": "object",
              "properties": {
                  "id": {
                      "type": "integer"
                  },
                  "userId": {
                      "type": "integer"
                  },
                  "title": {
                      "type": "string",
                      "minLength": 3,
                      "maxLength": 16,
                      "pattern": "[A-z]+"
                  },
                  "date": {
                      "type": "string"
                  }
              },
              "required": [
                  "title",
                  "date"
              ],
              "additionalProperties": false
          }
    responses:
      200:
        body:
          application/json:
            schema: |
              {
                  "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
                  "id": "urn:schema.phpsx.org#",
                  "type": "object",
                  "properties": {
                      "success": {
                          "type": "boolean"
                      },
                      "message": {
                          "type": "string"
                      }
                  },
                  "additionalProperties": false
              }
  put:
    body:
      application/json:
        schema: |
          {
              "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
              "id": "urn:schema.phpsx.org#",
              "type": "object",
              "properties": {
                  "id": {
                      "type": "integer"
                  },
                  "userId": {
                      "type": "integer"
                  },
                  "title": {
                      "type": "string",
                      "minLength": 3,
                      "maxLength": 16,
                      "pattern": "[A-z]+"
                  },
                  "date": {
                      "type": "string"
                  }
              },
              "required": [
                  "id"
              ],
              "additionalProperties": false
          }
    responses:
      200:
        body:
          application/json:
            schema: |
              {
                  "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
                  "id": "urn:schema.phpsx.org#",
                  "type": "object",
                  "properties": {
                      "success": {
                          "type": "boolean"
                      },
                      "message": {
                          "type": "string"
                      }
                  },
                  "additionalProperties": false
              }
  delete:
    body:
      application/json:
        schema: |
          {
              "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
              "id": "urn:schema.phpsx.org#",
              "type": "object",
              "properties": {
                  "id": {
                      "type": "integer"
                  },
                  "userId": {
                      "type": "integer"
                  },
                  "title": {
                      "type": "string",
                      "minLength": 3,
                      "maxLength": 16,
                      "pattern": "[A-z]+"
                  },
                  "date": {
                      "type": "string"
                  }
              },
              "required": [
                  "id"
              ],
              "additionalProperties": false
          }
    responses:
      200:
        body:
          application/json:
            schema: |
              {
                  "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
                  "id": "urn:schema.phpsx.org#",
                  "type": "object",
                  "properties": {
                      "success": {
                          "type": "boolean"
                      },
                      "message": {
                          "type": "string"
                      }
                  },
                  "additionalProperties": false
              }

RAML;

		$this->assertEquals(str_replace(array("\r\n", "\r"), "\n", $expect), $raml);
	}
}