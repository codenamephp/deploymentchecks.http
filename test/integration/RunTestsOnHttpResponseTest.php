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

namespace de\codenamephp\deploymentchecks\http\test\integration;

use de\codenamephp\deploymentchecks\base\Check\Collection\SequentialCheckCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\http\HttpCheckResult;
use de\codenamephp\deploymentchecks\http\RunTestsOnHttpResponse;
use de\codenamephp\deploymentchecks\http\Test\CssSelectorExists;
use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use de\codenamephp\deploymentchecks\http\Test\StatusCode;
use de\codenamephp\deploymentchecks\http\testHelper\BaseUri;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class RunTestsOnHttpResponseTest extends TestCase {

  public function testCanRunSuccessfulTest() : void {
    $check = new RunTestsOnHttpResponse(
      new Request('GET', new BaseUri() . '/test.html'),
      'Test',
      new StatusCode(200),
      new CssSelectorExists('body > h1'),
    );

    $result = $check->run();

    self::assertInstanceOf(HttpCheckResult::class, $result);
    self::assertTrue($result->successful());
    self::assertSame('Test', $result->name());
    self::assertContainsEquals(new HttpTestResult(true, "Expected response code '200' got '200'"), $result->testResults->results);
  }

  public function testCanRunSuccessfulTestCollection() : void {
    $check = new SequentialCheckCollection(new RunTestsOnHttpResponse(
      new Request('GET', new BaseUri() . '/test.html'),
      'Exists',
      new StatusCode(200),
    ),
      new RunTestsOnHttpResponse(
        new Request('GET', new BaseUri() . '/404.html'),
        'Does not exist',
        new StatusCode(404),
      ),
    );

    $result = $check->run();

    self::assertInstanceOf(ResultCollection::class, $result);
    self::assertTrue($result->successful());

    self::assertEquals(
      [
        new HttpCheckResult(
          'Exists',
          new HttpTestResult(true, "Expected response code '200' got '200'"),
        ),
        new HttpCheckResult(
          'Does not exist',
          new HttpTestResult(true, "Expected response code '404' got '404'"),
        ),
      ],
      $result->results,
    );
  }
}
