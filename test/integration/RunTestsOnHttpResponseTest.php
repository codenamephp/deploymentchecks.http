<?php declare(strict_types=1);

namespace de\codenamephp\deploymentchecks\http\integration;

use de\codenamephp\deploymentchecks\http\HttpCheckResult;
use de\codenamephp\deploymentchecks\http\integration\Data\BaseUri;
use de\codenamephp\deploymentchecks\http\RunTestsOnHttpResponse;
use de\codenamephp\deploymentchecks\http\Test\Result\HttpTestResult;
use de\codenamephp\deploymentchecks\http\Test\StatusCode;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class RunTestsOnHttpResponseTest extends TestCase
{

    public function testCanRunSuccessfulTest(): void
    {

        $check = new RunTestsOnHttpResponse(
            new Request('GET', new BaseUri() . '/test.html'),
            'Test',
            new StatusCode(200),
        );

        $result = $check->run();

        self::assertInstanceOf(HttpCheckResult::class, $result);
        self::assertTrue($result->successful());
        self::assertSame('Test', $result->name());
        self::assertContainsEquals(new HttpTestResult(true, "Expected response code '200' got '200'"), $result->testResults->results);
    }
}
