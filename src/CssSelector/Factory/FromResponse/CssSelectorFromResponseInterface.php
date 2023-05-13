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

namespace de\codenamephp\deploymentchecks\http\CssSelector\Factory\FromResponse;

use de\codenamephp\deploymentchecks\http\CssSelector\CssSelectorInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface to create a CssSelectorInterface from a http response
 */
interface CssSelectorFromResponseInterface {

  /**
   * Creates the selector from the response, e.g. by passing the body to a parser and creating the selector from that
   *
   * @param ResponseInterface $response The response to create the selector from
   * @return CssSelectorInterface
   */
  public function build(ResponseInterface $response) : CssSelectorInterface;
}
