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

namespace de\codenamephp\deploymentchecks\http\CssSelector\Factory\FromResponse;

use de\codenamephp\deploymentchecks\http\CssSelector\CssSelectorInterface;
use de\codenamephp\deploymentchecks\http\CssSelector\SymfonyDomCrawlerAdapter;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Just uses the string of the response body to create a new Crawler to pass to a new SymfonyDomCrawlerAdapter
 */
final class SymfonyAdapterFromResponseBody implements CssSelectorFromResponseInterface {

  public function build(ResponseInterface $response) : CssSelectorInterface {
    return new SymfonyDomCrawlerAdapter(new Crawler($response->getBody()->__toString()));
  }
}
