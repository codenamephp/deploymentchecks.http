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

namespace de\codenamephp\deploymentchecks\http\integration\ClientFactory;

use de\codenamephp\deploymentchecks\http\ClientFactory\GuzzleClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class GuzzleClientTest extends TestCase {

  public function testWithConfig() : void {
    $factory = (new GuzzleClient(['foo' => 'bar']))->withConfig(['new' => 'config']);

    self::assertSame(['new' => 'config'], $factory->config);
  }

  public function test__construct() : void {
    $factory = new GuzzleClient(['foo' => 'bar']);

    self::assertSame(['foo' => 'bar'], $factory->config);
  }

  public function testCreate() : void {
    $factory = new GuzzleClient(['foo' => 'bar']);

    $client = $factory->create();

    self::assertInstanceOf(Client::class, $client);

    $config = (new ReflectionClass($client))->getProperty('config')->getValue($client);

    self::assertArrayHasKey('foo', $config);
    self::assertSame('bar', $config['foo']);
  }

  public function testWithMergedConfig() : void {
    $factory = (new GuzzleClient(['foo' => 'bar', 'merge' => 'this']))->withMergedConfig(['new' => 'config', 'merge' => 'that']);

    self::assertSame(['foo' => 'bar', 'merge' => 'that', 'new' => 'config'], $factory->config);
  }
}
