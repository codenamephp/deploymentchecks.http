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

use de\codenamephp\deploymentchecks\http\CssSelector\CssSelectorInterface;
use de\codenamephp\deploymentchecks\http\CssSelector\Factory\FromResponse\CssSelectorFromResponseInterface;
use de\codenamephp\deploymentchecks\http\Test\CssSelectorExists;
use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

final class CssSelectorExistsTest extends TestCase {

  public function test__construct() : void {
    $selector = 'selector';
    $factory = $this->createMock(CssSelectorFromResponseInterface::class);

    $sut = new CssSelectorExists($selector, $factory);

    $this->assertSame($selector, $sut->selector);
    $this->assertSame($factory, $sut->cssSelectorFromResponseFactory);
  }

  public function testTest() : void {
    $selector = 'selector';

    $response = $this->createMock(ResponseInterface::class);

    $cssSelector = $this->createMock(CssSelectorInterface::class);
    $cssSelector->expects($this->once())->method('exists')->with($selector)->willReturn(true);

    $factory = $this->createMock(CssSelectorFromResponseInterface::class);
    $factory->expects($this->once())->method('build')->with($response)->willReturn($cssSelector);

    self::assertEquals(new HttpTestResult(true, "Expected to that selector '{$selector}' exists in the response body."), (new CssSelectorExists($selector, $factory))->test($response));
  }
}
