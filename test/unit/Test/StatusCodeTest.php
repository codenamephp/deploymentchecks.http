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

namespace de\codenamephp\deploymentchecks\http\test\unit\Test;

use de\codenamephp\deploymentchecks\http\Test\StatusCode;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

final class StatusCodeTest extends TestCase {

  public function testTest() : void {
    $expectedResponseCode = 200;
    $responseCode = 200;

    $response = $this->createMock(ResponseInterface::class);
    $response->method('getStatusCode')->willReturn($responseCode);

    $test = new StatusCode($expectedResponseCode);
    $result = $test->test($response);

    self::assertTrue($result->successful());
    self::assertSame(sprintf("Expected response code '%d' got '%d'", $expectedResponseCode, $responseCode), $result->message());
  }

  public function testTest_canReturnUnsuccessful() : void {
    $expectedResponseCode = 200;
    $responseCode = 404;

    $response = $this->createMock(ResponseInterface::class);
    $response->method('getStatusCode')->willReturn($responseCode);

    $test = new StatusCode($expectedResponseCode);
    $result = $test->test($response);

    self::assertFalse($result->successful());
    self::assertSame(sprintf("Expected response code '%d' got '%d'", $expectedResponseCode, $responseCode), $result->message());
  }

  public function test__construct() : void {
    $expectedResponseCode = 200;

    $test = new StatusCode($expectedResponseCode);

    self::assertSame($expectedResponseCode, $test->expectedResponseCode);
  }
}
