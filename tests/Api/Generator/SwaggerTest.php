<?php

namespace PSX\Project\Tests\Api\Generator;

use PSX\Project\Tests\ApiTestCase;

class SwaggerTest extends ApiTestCase
{
    public function testGet()
    {
        $response = $this->sendRequest('http://127.0.0.1/generator/swagger', 'GET');

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "swaggerVersion": "1.2",
    "apiVersion": "1.0",
    "apis": [
        {
            "path": "\/*\/population\/annotation"
        },
        {
            "path": "\/*\/population\/annotation\/{id}"
        },
        {
            "path": "\/*\/population\/raml"
        },
        {
            "path": "\/*\/population\/raml\/{id}"
        },
        {
            "path": "\/*\/population"
        },
        {
            "path": "\/*\/population\/{id}"
        }
    ]
}
JSON;

        $this->assertEquals(null, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testGetDetail()
    {
        $response = $this->sendRequest('http://127.0.0.1/generator/swagger/*/population/annotation', 'GET');

        $body   = (string) $response->getBody();
        $expect = <<<'JSON'
{
    "swaggerVersion": "1.2",
    "apiVersion": 0,
    "basePath": "http:\/\/127.0.0.1\/",
    "resourcePath": "\/population\/annotation",
    "apis": [
        {
            "path": "\/population\/annotation",
            "description": "Collection endpoint",
            "operations": [
                {
                    "method": "GET",
                    "nickname": "getCollection",
                    "parameters": [
                        {
                            "paramType": "query",
                            "name": "startIndex",
                            "type": "integer"
                        },
                        {
                            "paramType": "query",
                            "name": "count",
                            "type": "integer"
                        }
                    ],
                    "responseMessages": [
                        {
                            "code": 200,
                            "message": "Collection result",
                            "responseModel": "GET-200-response"
                        }
                    ]
                },
                {
                    "method": "POST",
                    "nickname": "postEntity",
                    "parameters": [
                        {
                            "paramType": "body",
                            "name": "body",
                            "description": "Represents an internet population entity",
                            "required": true,
                            "type": "POST-request"
                        }
                    ],
                    "responseMessages": [
                        {
                            "code": 201,
                            "message": "Operation message",
                            "responseModel": "POST-201-response"
                        }
                    ]
                }
            ]
        }
    ],
    "models": {
        "ref12427a2a4da80c722d6d54e518488d16": {
            "id": "ref12427a2a4da80c722d6d54e518488d16",
            "properties": {
                "startIndex": {
                    "type": "integer"
                },
                "count": {
                    "type": "integer"
                }
            }
        },
        "ref11097597650a2b8da8978e836e225413": {
            "id": "ref11097597650a2b8da8978e836e225413",
            "description": "Represents an internet population entity",
            "required": [
                "place",
                "region",
                "population",
                "users",
                "world_users"
            ],
            "properties": {
                "id": {
                    "type": "integer",
                    "description": "Unique id for each entry"
                },
                "place": {
                    "type": "integer",
                    "description": "Position in the top list"
                },
                "region": {
                    "type": "string",
                    "description": "Name of the region",
                    "minLength": 3,
                    "maxLength": 64,
                    "pattern": "[A-z]+"
                },
                "population": {
                    "type": "integer",
                    "description": "Complete number of population"
                },
                "users": {
                    "type": "integer",
                    "description": "Number of internet users"
                },
                "world_users": {
                    "type": "number",
                    "description": "Percentage users of the world"
                },
                "datetime": {
                    "type": "string",
                    "description": "Date when the entity was created"
                }
            }
        },
        "ref86e9674085c91e87e8e04206e7c53f16": {
            "id": "ref86e9674085c91e87e8e04206e7c53f16",
            "description": "Collection result",
            "properties": {
                "totalResults": {
                    "type": "integer"
                },
                "entry": {
                    "type": "array",
                    "items": {
                        "$ref": "ref11097597650a2b8da8978e836e225413"
                    },
                    "title": "entry"
                }
            }
        },
        "ref31ead4d236fd038a7d55a40e2ca1171e": {
            "id": "ref31ead4d236fd038a7d55a40e2ca1171e",
            "description": "Operation message",
            "properties": {
                "success": {
                    "type": "boolean"
                },
                "message": {
                    "type": "string"
                }
            }
        },
        "GET-query": {
            "id": "GET-query",
            "properties": {
                "startIndex": {
                    "type": "integer"
                },
                "count": {
                    "type": "integer"
                }
            }
        },
        "GET-200-response": {
            "id": "GET-200-response",
            "description": "Collection result",
            "properties": {
                "totalResults": {
                    "type": "integer"
                },
                "entry": {
                    "type": "array",
                    "items": {
                        "$ref": "ref11097597650a2b8da8978e836e225413"
                    },
                    "title": "entry"
                }
            }
        },
        "POST-request": {
            "id": "POST-request",
            "description": "Represents an internet population entity",
            "required": [
                "place",
                "region",
                "population",
                "users",
                "world_users"
            ],
            "properties": {
                "id": {
                    "type": "integer",
                    "description": "Unique id for each entry"
                },
                "place": {
                    "type": "integer",
                    "description": "Position in the top list"
                },
                "region": {
                    "type": "string",
                    "description": "Name of the region",
                    "minLength": 3,
                    "maxLength": 64,
                    "pattern": "[A-z]+"
                },
                "population": {
                    "type": "integer",
                    "description": "Complete number of population"
                },
                "users": {
                    "type": "integer",
                    "description": "Number of internet users"
                },
                "world_users": {
                    "type": "number",
                    "description": "Percentage users of the world"
                },
                "datetime": {
                    "type": "string",
                    "description": "Date when the entity was created"
                }
            }
        },
        "POST-201-response": {
            "id": "POST-201-response",
            "description": "Operation message",
            "properties": {
                "success": {
                    "type": "boolean"
                },
                "message": {
                    "type": "string"
                }
            }
        }
    }
}
JSON;

        $this->assertEquals(null, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }
}
