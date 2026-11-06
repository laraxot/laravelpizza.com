<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Modules\Cms\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Contracts\UserContract as XotUserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;

use function Safe\file_get_contents;
use function Safe\json_decode;

/*
 * Helper Pest/PHPStan — modulo Cms.
 *
 * Funzioni globali (autoload-dev.files). Nessun namespace: i test devono
 * chiamarle senza `use function Modules\Cms\Tests\...`.
 *
 * Ogni funzione e' dietro `function_exists`: merge paralleli e doppio
 * autoload non devono produrre "Cannot redeclare". Story ROOT-17.10.
 *
 * @see Modules/Gdpr/tests/PestHelpers.php
 */
if (! function_exists('cmsTest')) {
    function cmsTest(): TestCase
    {
        return TestCase::$currentTest ?? throw new LogicException('cmsTest() va chiamato durante un test che estende Modules\Cms\Tests\TestCase.');
    }
}

if (! function_exists('cmsGenerateUniqueEmail')) {
    function cmsGenerateUniqueEmail(): string
    {
        return TestCase::pestGenerateUniqueEmail();
    }
}

if (! function_exists('cmsCreateTestUser')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function cmsCreateTestUser(array $attributes = []): XotUserContract
    {
        /** @var XotUserContract $user */
        $user = TestCase::pestCreateTestUser($attributes);

        return $user;
    }
}

if (! function_exists('cmsCreateUnverifiedUser')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function cmsCreateUnverifiedUser(array $attributes = []): XotUserContract
    {
        $user = UserFactory::new()->unverified()->createOne($attributes);
        assert($user instanceof XotUserContract);

        return $user;
    }
}

if (! function_exists('cmsCreateMock')) {
    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&MockObject
     */
    function cmsCreateMock(string $class): MockObject
    {
        return cmsTest()->createPHPUnitMock($class);
    }
}

if (! function_exists('cmsMockXotData')) {
    function cmsMockXotData(): void
    {
        XotData::make()->update(['main_module' => 'User']);
    }
}

if (! function_exists('cmsReadFile')) {
    function cmsReadFile(string $path): string
    {
        return file_get_contents($path);
    }
}

if (! function_exists('cmsJsonDecodeFile')) {
    /**
     * @return array<string, mixed>
     */
    function cmsJsonDecodeFile(string $path): array
    {
        /** @var array<string, mixed> $decoded */
        $decoded = json_decode(cmsReadFile($path), true);

        return $decoded;
    }
}

if (! function_exists('cmsHomepageBlocks')) {
    /**
     * Blocchi della homepage del tenant per una lingua (loader tipizzato su `TestCase`).
     *
     * @return list<array{type: string, data: array<string, mixed>}>
     */
    function cmsHomepageBlocks(string $locale): array
    {
        return TestCase::homepageBlocksForLocale($locale);
    }
}

if (! function_exists('cmsGet')) {
    /**
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsGet(string $uri, array $headers = []): TestResponse
    {
        return cmsTest()->get($uri, $headers);
    }
}

if (! function_exists('cmsGetOrSkipOnServerError')) {
    /**
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsGetOrSkipOnServerError(string $uri, array $headers = []): TestResponse
    {
        $response = cmsGet($uri, $headers);

        if ((int) $response->getStatusCode() >= 500) {
            cmsSkipTest('Server error on '.$uri.': '.$response->getStatusCode());
        }

        return $response;
    }
}

if (! function_exists('cmsPost')) {
    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsPost(string $uri, array $data = [], array $headers = []): TestResponse
    {
        return cmsTest()->post($uri, $data, $headers);
    }
}

if (! function_exists('cmsActingAs')) {
    function cmsActingAs(Authenticatable $user, ?string $driver = null): TestCase
    {
        return cmsTest()->actingAs($user, $driver);
    }
}

if (! function_exists('cmsActingAsGet')) {
    /**
     * Autenticato + GET in un passo (verify-email e route signed).
     *
     * @param  array<string, string>  $headers
     * @return TestResponse<Response>
     */
    function cmsActingAsGet(Authenticatable $user, string $uri, array $headers = []): TestResponse
    {
        return cmsActingAs($user)->get($uri, $headers);
    }
}

if (! function_exists('cmsSkipTest')) {
    function cmsSkipTest(string $message = ''): void
    {
        cmsTest()->markTestSkipped($message);
    }
}

if (! function_exists('cmsAssertAuthenticated')) {
    function cmsAssertAuthenticated(?string $guard = null): void
    {
        Assert::assertTrue(Auth::guard($guard)->check());
    }
}

if (! function_exists('cmsAssertGuest')) {
    function cmsAssertGuest(?string $guard = null): void
    {
        Assert::assertFalse(Auth::guard($guard)->check());
    }
}

if (! function_exists('loadHomepageJsonForBlocksArchitectureTest')) {
    /**
     * Wrapper del metodo su TestCase (fonte di verità PSR-4).
     *
     * Preferire `TestCase::homepageJsonForBlocksArchitecture()` nei test namespaced.
     *
     * @return array<string, mixed>
     */
    function loadHomepageJsonForBlocksArchitectureTest(): array
    {
        return TestCase::homepageJsonForBlocksArchitecture();
    }
}
