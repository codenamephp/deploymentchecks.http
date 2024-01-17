<?php declare(strict_types=1);
/*
 *  Copyright 2024 Bastian Schwarz <bastian@codename-php.de>.
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

namespace de\codenamephp\deploymentchecks\http\CssSelector;

use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Adapter for the Symfony DomCrawler to run a CSS selector and check if it exists
 */
final readonly class SymfonyDomCrawlerAdapter implements CssSelectorInterface {

  public function __construct(public Crawler $crawler) {}

  public function exists(string $selector) : bool {
    return class_exists(CssSelectorConverter::class) && $this->crawler->filter($selector)->count() > 0;
  }
}
