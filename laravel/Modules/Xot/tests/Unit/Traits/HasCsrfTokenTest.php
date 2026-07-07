<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('sets csrf token on mount', function (): void {
    $token = 'test-token-123';

    $session = Mockery::mock();
    $session->allows(['token' => $token]);
    App::instance('session', $session);

    $class = new class {
        public string $_token = '';

        public function mount(): void
        {
            $this->_token = app('session')->token();
        }

        public function getCsrfToken(): string
        {
            return $this->_token;
        }
    };

    $class->mount();

    Assert::assertSame($token, $class->getCsrfToken());
    Mockery::close();
});

it('verifies csrf token', function (): void {
    $token = 'secret-token';

    $class = new class {
        public string $_token = '';

        public function verifyCsrfToken(): bool
        {
            return $this->_token === app('session')->token();
        }
    };
    $class->_token = $token;

    Session::partialMock()->allows(['token' => $token]);

    Assert::assertTrue($class->verifyCsrfToken());
    Mockery::close();
});
