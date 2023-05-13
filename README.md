# deploymentchecks.http

![Packagist Version](https://img.shields.io/packagist/v/codenamephp/deploymentchecks.http)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/codenamephp/deploymentchecks.http)
![Lines of code](https://img.shields.io/tokei/lines/github/codenamephp/deploymentchecks.http)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/codenamephp/deploymentchecks.http)
![CI](https://github.com/codenamephp/deploymentchecks.http/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/codenamephp/deploymentchecks.http)
![GitHub](https://img.shields.io/github/license/codenamephp/deploymentchecks.http)

This package provides simple checks for http services. It can check if a service is reachable and if it returns a specific status code, response body, ...

## Installation

Easiest way is via composer. Just run `composer require codenamephp/deploymentchecks.http` in your cli which should install the latest version for you.

You should also explicitly install the `codenamephp/deploymentchecks.base` package since you will end up using it directly in almost all cases.

## Usage

Just create checks, pass them to a collection and run them:

```php
use de\codenamephp\deploymentchecks\base\Check\Collection\SequentialCheckCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\http\HttpCheckResult;
use de\codenamephp\deploymentchecks\http\RunTestsOnHttpResponse;
use de\codenamephp\deploymentchecks\http\Test\CssSelectorExists;
use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use de\codenamephp\deploymentchecks\http\Test\StatusCode;
use GuzzleHttp\Psr7\Request;

$check = new SequentialCheckCollection(new RunTestsOnHttpResponse(
  new Request('GET', 'https://localhost/test.html'),
  'Exists',
  new StatusCode(200),
),
  new RunTestsOnHttpResponse(
    new Request('GET','https://localhost/404.html'),
    'Does not exist',
    new StatusCode(404),
  ),
);

$result = $check->run();

exit($result instanceof WithExitCodeInterface ? $result->exitCode() : ($result->successful() ? DefaultExitCodes::SUCCESSFUL->value : DefaultExitCodes::ERROR->value));
```
