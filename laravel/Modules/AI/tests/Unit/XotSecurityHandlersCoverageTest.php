<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Modules\Xot\Exceptions\Handlers\HandlersRepository;
use Modules\Xot\Http\Middleware\SecurityMiddleware;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot security handlers deep', function (): void {
    test('SecurityMiddleware adds the security headers to a successful response', function (): void {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();
        Log::shouldReceive('warning')->zeroOrMoreTimes();
        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('debug')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $mw = new SecurityMiddleware;
        $next = static fn (Request $r): Response => new Response('ok', 200);
        $response = $mw->handle(Request::create('/health', 'GET'), $next);

        Assert::assertSame('DENY', $response->headers->get('X-Frame-Options'));
        Assert::assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
        Assert::assertNotNull($response->headers->get('Content-Security-Policy'));
    });

    test('SecurityMiddleware rejects an IP over the endpoint limit', function (): void {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();
        Log::shouldReceive('warning')->once();

        $ip = '203.0.113.99';
        Cache::put("rate_limit:ip:{$ip}", 60, 60);
        $request = Request::create('/api/flood', 'GET', [], [], [], ['REMOTE_ADDR' => $ip]);

        try {
            (new SecurityMiddleware)->handle($request, static fn (): Response => new Response('ok'));
            Assert::fail('The request exceeded the configured IP rate limit.');
        } catch (HttpException $exception) {
            Assert::assertSame(429, $exception->getStatusCode());
            Assert::assertSame('Too Many Requests', $exception->getMessage());
        }
    });

    test('HandlersRepository type-filtered handlers', function (): void {
        Http::fake();
        Mail::fake();
        Queue::fake();
        Process::fake();

        $repo = new HandlersRepository;
        $repo->addReporter(static function (\InvalidArgumentException $e): void {});
        $repo->addReporter(static function (\Throwable $e): void {});
        $repo->addReporter(static function (): void {}); // no params → false
        $repo->addRenderer(static function (\RuntimeException $e): string {
            return 'r';
        });
        $repo->addConsoleRenderer(static function (string $e): void {}); // builtin type → true

        $a = new \InvalidArgumentException('a');
        $b = new \RuntimeException('b');
        Assert::assertNotEmpty($repo->getReportersByException($a));
        Assert::assertNotEmpty($repo->getReportersByException($b));
        Assert::assertNotEmpty($repo->getRenderersByException($b));
        Assert::assertNotEmpty($repo->getConsoleRenderersByException($b));
    });
});
