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

namespace de\codenamephp\deploymentchecks\http\Test;

use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use Psr\Http\Message\ResponseInterface;

/**
 * Does a strict comparison of the status code of the response with the expected one
 *
 * @psalm-api
 */
final readonly class StatusCode implements TestInterface {

  public function __construct(public int $expectedResponseCode) {}

  public function test(ResponseInterface $response) : HttpTestResult {
    return new HttpTestResult(
      $response->getStatusCode() === $this->expectedResponseCode,
      sprintf("Expected response code '%d' got '%d'", $this->expectedResponseCode, $response->getStatusCode()),
    );
  }
}
