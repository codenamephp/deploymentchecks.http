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

namespace de\codenamephp\deploymentchecks\http\test\unit\CssSelector\Factory\FromResponse;

use de\codenamephp\deploymentchecks\http\CssSelector\Factory\FromResponse\SymfonyAdapterFromResponseBody;
use de\codenamephp\deploymentchecks\http\CssSelector\SymfonyDomCrawlerAdapter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

final class SymfonyAdapterFromResponseBodyTest extends TestCase {

  public function testBuild() : void {
    $body = $this->createMock(StreamInterface::class);
    $body->method('__toString')->willReturn('<html lang=""><body><div>test</div></body></html>');

    $response = $this->createMock(ResponseInterface::class);
    $response->method('getBody')->willReturn($body);

    self::assertEquals(new SymfonyDomCrawlerAdapter(new Crawler('<html lang=""><body><div>test</div></body></html>')), (new SymfonyAdapterFromResponseBody())->build($response));
  }
}
