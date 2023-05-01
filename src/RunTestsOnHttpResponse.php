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

namespace de\codenamephp\deploymentchecks\http;

use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\base\Check\WithNameInterface;
use de\codenamephp\deploymentchecks\http\ClientFactory\ClientFactoryInterface;
use de\codenamephp\deploymentchecks\http\ClientFactory\GuzzleClient;
use de\codenamephp\deploymentchecks\http\Test\TestInterface;
use Psr\Http\Message\RequestInterface;

/**
 * A check that sends a PSR Request using a PSR client and runs the given tests on the response and returns their results as collection.
 *
 * The client is created using the client factory as we cannot have a Guzzle Client set as default because the async package (which this is supposed to be
 * compatible to) uses serialize/unserialize which would fail with a guzzle client due to the closures as middleware in the stack.
 */
final class RunTestsOnHttpResponse implements CheckInterface, WithNameInterface {

  /**
   * @var array<TestInterface>
   */
  public array $tests = [];

  public ClientFactoryInterface $clientFactory;

  public function __construct(
    public readonly RequestInterface $request,
    public readonly string $name,
    TestInterface ...$tests
  ) {
    $this->tests = $tests;
    $this->clientFactory = new GuzzleClient();
  }

  public function name() : string {
    return $this->name;
  }

  public function run() : ResultInterface {
    $response = $this->clientFactory->create()->send($this->request);
    return new HttpCheckResult($this->name(), ...array_map(fn(TestInterface $test) => $test->test($response), $this->tests));
  }
}
