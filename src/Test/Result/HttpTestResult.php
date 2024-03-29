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

namespace de\codenamephp\deploymentchecks\http\Test\Result;

use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\WithMessageInterface;

/**
 * A result that is returned by the http test check and contains the result of the test and a message, e.g. what the test tried to assert
 */
final readonly class HttpTestResult implements ResultInterface, WithMessageInterface {

  public function __construct(public bool $successful, public string $message) {}

  public function successful() : bool {
    return $this->successful;
  }

  public function message() : string {
    return $this->message;
  }
}
