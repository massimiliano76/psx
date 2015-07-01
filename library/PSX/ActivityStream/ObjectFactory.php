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

namespace PSX\ActivityStream;

use PSX\Data\Record\FactoryInterface;
use PSX\Data\Record\Importer;

/**
 * ObjectFactory
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ObjectFactory implements FactoryInterface
{
    /**
     * @Inject
     * @var \PSX\Data\Record\ImporterManager
     */
    protected $importerManager;

    public function factory($data)
    {
        if ($data instanceof \stdClass) {
            $class = null;

            if (isset($data->objectType) && !empty($data->objectType)) {
                $class = $this->resolveType($data->objectType);
            }

            if ($class !== null && class_exists($class)) {
                $object = new $class();
            } else {
                $object = new Object();
            }

            $importer = $this->importerManager->getImporterByInstance('PSX\Data\Record\Importer\Record');

            return $importer->import($object, $data);
        } elseif (is_array($data)) {
            $objects = array();

            foreach ($data as $row) {
                $objects[] = $this->factory($row);
            }

            return $objects;
        } else {
            return $data;
        }
    }

    protected function resolveType($type)
    {
        if ($type instanceof \stdClass) {
            $type = isset($type->id) ? $type->id : null;
        } else {
            $type = (string) $type;
        }

        $type  = strtolower($type);
        $class = null;

        switch ($type) {
            case 'activity':
            case 'audio':
            case 'binary':
            case 'collection':
            case 'event':
            case 'group':
            case 'issue':
            case 'permission':
            case 'place':
            case 'role':
            case 'task':
            case 'video':
                $class = 'PSX\\ActivityStream\\ObjectType\\' . ucfirst($type);
                break;
        }

        return $class;
    }
}
