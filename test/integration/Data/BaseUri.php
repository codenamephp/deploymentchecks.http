<?php declare(strict_types=1);

namespace de\codenamephp\deploymentchecks\http\integration\Data;

use InvalidArgumentException;

final class BaseUri
{

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
