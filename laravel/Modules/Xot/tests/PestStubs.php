<?php

declare(strict_types=1);
/**
 * Pest Laravel helper stubs for PHPStan.
 *
 * This file provides the missing `Pest\Laravel\*` functions that PHPStan
 * cannot resolve from the Pest extension alone.
 *
 * IMPORTANT:
 * - Do not call these functions in production code.
 * - This file is only for static analysis and test helper convenience.
 */

namespace Pest\Laravel;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Pest\PendingCalls\AfterEachCall;
use Pest\PendingCalls\BeforeEachCall;
use Pest\PendingCalls\DescribeCall;
use Pest\PendingCalls\TestCall;
use Pest\PendingCalls\UsesCall;

/**
 * Authenticate as a given model or ID.
 *
 * @return TestResponse<Response>
 */
function actingAs(Authenticatable|int|string|null $user = null, ?string $driver = null): TestResponse
{
    \xotPestStubFailure('actingAs', $user, $driver);
}

/**
 * Perform a GET request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $options
 * @return TestResponse<Response>
 */
function get(string|array $uri = '', array $options = []): TestResponse
{
    \xotPestStubFailure('get', $uri, $options);
}

/**
 * Perform a POST request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $options
 * @return TestResponse<Response>
 */
function post(string|array $uri, array $data = [], array $options = []): TestResponse
{
    \xotPestStubFailure('post', $uri, $data, $options);
}

/**
 * Perform a PUT request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @return TestResponse<Response>
 */
function put(string|array $uri, array $data = []): TestResponse
{
    \xotPestStubFailure('put', $uri, $data);
}

/**
 * Perform a PATCH request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @return TestResponse<Response>
 */
function patch(string|array $uri, array $data = []): TestResponse
{
    \xotPestStubFailure('patch', $uri, $data);
}

/**
 * Perform a DELETE request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @return TestResponse<Response>
 */
function delete(string|array $uri): TestResponse
{
    \xotPestStubFailure('delete', $uri);
}

/**
 * Perform a HEAD request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @return TestResponse<Response>
 */
function head(string|array $uri): TestResponse
{
    \xotPestStubFailure('head', $uri);
}

/**
 * Perform an OPTIONS request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @return TestResponse<Response>
 */
function options(string|array $uri): TestResponse
{
    \xotPestStubFailure('options', $uri);
}

/**
 * Perform a JSON GET request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $headers
 * @return TestResponse<Response>
 */
function getJson(string|array $uri, array $headers = []): TestResponse
{
    \xotPestStubFailure('getJson', $uri, $headers);
}

/**
 * Perform a JSON POST request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $headers
 * @return TestResponse<Response>
 */
function postJson(string|array $uri, array $data = [], array $headers = []): TestResponse
{
    \xotPestStubFailure('postJson', $uri, $data, $headers);
}

/**
 * Perform a JSON PUT request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $headers
 * @return TestResponse<Response>
 */
function putJson(string|array $uri, array $data = [], array $headers = []): TestResponse
{
    \xotPestStubFailure('putJson', $uri, $data, $headers);
}

/**
 * Perform a JSON PATCH request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $headers
 * @return TestResponse<Response>
 */
function patchJson(string|array $uri, array $data = [], array $headers = []): TestResponse
{
    \xotPestStubFailure('patchJson', $uri, $data, $headers);
}

/**
 * Perform a JSON DELETE request.
 *
 * @param  string|array<int|string, mixed>  $uri
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $headers
 * @return TestResponse<Response>
 */
function deleteJson(string|array $uri, array $data = [], array $headers = []): TestResponse
{
    \xotPestStubFailure('deleteJson', $uri, $data, $headers);
}

/**
 * Set the number of redirects to follow.
 *
 * @return TestResponse<Response>
 */
function followingRedirects(int $number = 5): TestResponse
{
    \xotPestStubFailure('followingRedirects', $number);
}

/**
 * Define a test case.
 */
function test(string $description, ?\Closure $closure = null): TestCall
{
    \xotPestStubFailure('test', $description, $closure);
}

/**
 * Define a test case.
 */
function it(string $description, ?\Closure $closure = null): TestCall
{
    \xotPestStubFailure('it', $description, $closure);
}

/**
 * Define a test group.
 */
function describe(string $description, \Closure $closure): DescribeCall
{
    \xotPestStubFailure('describe', $description, $closure);
}

/**
 * Define a before each hook.
 */
function beforeEach(\Closure $closure): BeforeEachCall
{
    \xotPestStubFailure('beforeEach', $closure);
}

/**
 * Define an after each hook.
 */
function afterEach(\Closure $closure): AfterEachCall
{
    \xotPestStubFailure('afterEach', $closure);
}

/**
 * Define a test class.
 *
 * @param  class-string  ...$classes
 */
function uses(string ...$classes): UsesCall
{
    \xotPestStubFailure('uses', ...$classes);
}
