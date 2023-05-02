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

namespace de\codenamephp\deploymentchecks\http\test\unit\Test\Result;

use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use PHPUnit\Framework\TestCase;

final class HttpTestResultTest extends TestCase {

  public function test__construct() : void {
    $sut = new HttpTestResult(true, 'message');

    self::assertTrue($sut->successful);
    self::assertSame('message', $sut->message);
  }

  public function testMessage() : void {
    $sut = new HttpTestResult(true, 'message');

    self::assertSame('message', $sut->message());
  }

  public function testSuccessful() : void {
    $sut = new HttpTestResult(true, 'message');

    self::assertTrue($sut->successful());
  }
}
