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

namespace PSX\Data\Schema\Property;

use PSX\Data\Schema\ValidationException;

/**
 * FloatType
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class FloatType extends DecimalType
{
	public function validate($data)
	{
		parent::validate($data);

		if($data === null)
		{
			return true;
		}

		if(is_float($data))
		{
		}
		else if(is_int($data))
		{
			$data = (float) $data;
		}
		else if(is_string($data))
		{
			$result = preg_match('/^(\+|-)?([0-9]+(\.[0-9]*)?|\.[0-9]+)([Ee](\+|-)?[0-9]+)?$/', $data);

			if($result)
			{
				$data = (float) $data;
			}
			else
			{
				throw new ValidationException($this->getName() . ' must be an float');
			}
		}
		else
		{
			throw new ValidationException($this->getName() . ' must be an float');
		}

		if($this->max !== null)
		{
			if($data > $this->max)
			{
				throw new ValidationException($this->getName() . ' must be lower or equal then ' . $this->max);
			}
		}

		if($this->min !== null)
		{
			if($data < $this->min)
			{
				throw new ValidationException($this->getName() . ' must be greater or equal then ' . $this->min);
			}
		}

		return true;
	}
}