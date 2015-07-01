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

namespace PSX\Filter;

use Doctrine\DBAL\Connection;
use PSX\FilterAbstract;

/**
 * Checks whether the value is in the column
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class InColumn extends FilterAbstract
{
    protected $connection;
    protected $tableName;
    protected $columnName;

    public function __construct(Connection $connection, $tableName, $columnName)
    {
        $this->connection = $connection;
        $this->tableName  = $tableName;
        $this->columnName = $columnName;
    }

    /**
     * Returns true if value is in the table
     *
     * @param mixed $value
     * @return boolean
     */
    public function apply($value)
    {
        $builder = $this->connection->createQueryBuilder()
            ->select($this->connection->getDatabasePlatform()->getCountExpression('*'))
            ->from($this->tableName, null)
            ->where($this->columnName . ' = :value');

        $count = (int) $this->connection->fetchColumn($builder->getSQL(), array(
            'value' => $value
        ));

        return $count > 0;
    }

    public function getErrorMessage()
    {
        return '%s is not a valid value';
    }
}
