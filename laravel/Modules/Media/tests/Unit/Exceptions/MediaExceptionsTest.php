<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Exceptions;

use Modules\Media\Exceptions\CouldNotAddUpload;
use Modules\Media\Exceptions\TemporaryUploadDoesNotBelongToCurrentSession;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * I due costruttori nominati del modulo: esistono per dare un messaggio stabile
 * a chi cattura l'eccezione, quindi il messaggio fa parte del contratto.
 */

uses(TestCase::class);

test('uuidAlreadyExists builds the duplicate upload exception', function (): void {
    $exception = CouldNotAddUpload::uuidAlreadyExists();

    Assert::assertSame(
        'The given uuid is being used for an existing media item.',
        $exception->getMessage(),
    );
});

test('create builds the session mismatch exception', function (): void {
    $exception = TemporaryUploadDoesNotBelongToCurrentSession::create();

    Assert::assertSame(
        'The session id of the given temporary upload does not match the current session id.',
        $exception->getMessage(),
    );
});

test('each call returns a fresh instance', function (): void {
    Assert::assertNotSame(
        CouldNotAddUpload::uuidAlreadyExists(),
        CouldNotAddUpload::uuidAlreadyExists(),
    );
});
