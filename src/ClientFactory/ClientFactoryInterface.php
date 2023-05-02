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

use Psr\Http\Client\ClientInterface;

/**
 * Interface to create a client on the fly since we cannot have closures (which the middleware stack usually consists of) in the objects when we
 * want to be compatible with the async package
 *
 * @psalm-api
 */
interface ClientFactoryInterface {

  /**
   * Creates a new PSR-18 client
   *
   * @return ClientInterface
   */
  public function create() : ClientInterface;
}
