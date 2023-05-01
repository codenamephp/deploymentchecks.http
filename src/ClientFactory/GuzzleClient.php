<?php declare(strict_types=1);
/*
 *  Copyright 2023 Bastian Schwarz <bastian@codename-php.de>.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace de\codenamephp\deploymentchecks\http\ClientFactory;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

final class GuzzleClient implements ClientFactoryInterface {

  public function __construct(public readonly array $config = []) {}

  public function create() : ClientInterface {
    return new Client($this->config);
  }

  public function withConfig(array $config) : self {
    return new self($config);
  }

  public function withMergedOptions(array $config) : self {
    return new self(array_merge($this->config, $config));
  }
}