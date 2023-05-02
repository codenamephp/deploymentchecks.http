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

use de\codenamephp\deploymentchecks\http\Test\BodyEquals;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class BodyEqualsTest extends TestCase {

  public function test__construct() : void {
    $expectedResponseText = 'expectedResponseText';

    $sut = new BodyEquals($expectedResponseText);

    self::assertSame($expectedResponseText, $sut->expectedResponseText);
  }

  public function testTest() : void {
    $expectedResponseText = 'some body';

    $responseText = 'some body';
    $body = $this->createMock(StreamInterface::class);
    $body->expects(self::exactly(2))->method('__toString')->willReturn($responseText);

    $response = $this->createMock(ResponseInterface::class);
    $response->expects(self::exactly(2))->method('getBody')->willReturn($body);

    $sut = new BodyEquals($expectedResponseText);

    $result = $sut->test($response);

    self::assertTrue($result->successful());
    self::assertSame(sprintf("Expected response text '%s' got '%s'", $expectedResponseText, $responseText), $result->message());
  }

  public function testTest_canReturnUnsuccessful() : void {
    $expectedResponseText = 'some other body';

    $responseText = 'some body';
    $body = $this->createMock(StreamInterface::class);
    $body->expects(self::exactly(2))->method('__toString')->willReturn($responseText);

    $response = $this->createMock(ResponseInterface::class);
    $response->expects(self::exactly(2))->method('getBody')->willReturn($body);

    $sut = new BodyEquals($expectedResponseText);

    $result = $sut->test($response);

    self::assertFalse($result->successful());
    self::assertSame(sprintf("Expected response text '%s' got '%s'", $expectedResponseText, $responseText), $result->message());
  }
}
