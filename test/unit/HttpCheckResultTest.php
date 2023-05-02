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

namespace de\codenamephp\deploymentchecks\http\test\unit;

use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\http\HttpCheckResult;
use PHPUnit\Framework\TestCase;

final class HttpCheckResultTest extends TestCase {

  public function test__construct() : void {
    $result = new HttpCheckResult('name');

    self::assertSame('name', $result->name);
  }

  public function test__construct_withOptionalArguments() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result2 = $this->createMock(ResultInterface::class);
    $result3 = $this->createMock(ResultInterface::class);

    $result = new HttpCheckResult('name', $result1, $result2, $result3);

    self::assertSame('name', $result->name);
    self::assertSame([$result1, $result2, $result3], $result->testResults->results);
  }

  public function testSuccessful() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result1->method('successful')->willReturn(true);
    $result2 = $this->createMock(ResultInterface::class);
    $result2->method('successful')->willReturn(true);
    $result3 = $this->createMock(ResultInterface::class);
    $result3->method('successful')->willReturn(false);

    $result = new HttpCheckResult('name', $result1, $result2, $result3);

    self::assertFalse($result->successful());
  }

  public function testSuccessful_canReturnSuccess() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result1->method('successful')->willReturn(true);
    $result2 = $this->createMock(ResultInterface::class);
    $result2->method('successful')->willReturn(true);
    $result3 = $this->createMock(ResultInterface::class);
    $result3->method('successful')->willReturn(true);

    $result = new HttpCheckResult('name', $result1, $result2, $result3);

    self::assertTrue($result->successful());
  }

  public function testAdd() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result2 = $this->createMock(ResultInterface::class);
    $result3 = $this->createMock(ResultInterface::class);

    $result = new HttpCheckResult('name', $result1, $result2);

    self::assertSame($result, $result->add($result3));

    self::assertSame([$result1, $result2, $result3], $result->testResults->results);
  }

  public function testName() : void {
    $result = new HttpCheckResult('name');

    self::assertSame('name', $result->name());
  }
}
