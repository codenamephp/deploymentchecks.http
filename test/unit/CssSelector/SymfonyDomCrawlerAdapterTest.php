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

namespace de\codenamephp\deploymentchecks\http\test\unit\CssSelector;

use de\codenamephp\deploymentchecks\http\CssSelector\SymfonyDomCrawlerAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

final class SymfonyDomCrawlerAdapterTest extends TestCase {

  public function testExists() : void {
    $crawler = $this->createMock(Crawler::class);
    $crawler->expects(self::once())->method('filter')->with('selector')->willReturnSelf();
    $crawler->expects(self::once())->method('count')->willReturn(1);

    $sut = new SymfonyDomCrawlerAdapter($crawler);

    self::assertTrue($sut->exists('selector'));
  }

  public function testExists_canReturnFalse_for0() : void {
    $crawler = $this->createMock(Crawler::class);
    $crawler->expects(self::once())->method('filter')->with('selector')->willReturnSelf();
    $crawler->expects(self::once())->method('count')->willReturn(0);

    $sut = new SymfonyDomCrawlerAdapter($crawler);

    self::assertFalse($sut->exists('selector'));
  }

  public function test__construct() : void {
    $crawler = $this->createMock(Crawler::class);

    $sut = new SymfonyDomCrawlerAdapter($crawler);

    self::assertSame($crawler, $sut->crawler);
  }
}
