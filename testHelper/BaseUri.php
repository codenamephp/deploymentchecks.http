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

namespace de\codenamephp\deploymentchecks\http\testHelper;

use InvalidArgumentException;

/**
 * Simple value object to access the base uri for the integration tests that may or may not be set using env vars.
 */
final class BaseUri {

  public function __construct(private ?string $scheme = null, private ?string $host = null, private ?int $port = null,)
    {
        $this->scheme = $scheme ?? (string)getenv('INTEGRATION_TESTS_SCHEME');
        $this->host = $host ?? (string)getenv('INTEGRATION_TESTS_HOST');
        $this->port = $port ?? (int)getenv('INTEGRATION_TESTS_PORT');

        match (true) {
            $this->scheme === '' => throw new InvalidArgumentException('Scheme cannot be empty'),
            $this->host === '' => throw new InvalidArgumentException('Host cannot be empty'),
            $this->port === 0 => $this->port = null,
            default => null,
        };
    }

    public function __toString(): string
    {
        return "{$this->scheme}://{$this->host}" . match (true) {
                $this->port === 80 && $this->scheme === 'http', $this->port === 443 && $this->scheme === 'https', $this->port === null => '',
                default => ":{$this->port}",
            };
    }
}
