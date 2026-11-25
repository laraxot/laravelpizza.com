<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Datas;

use Modules\Xot\Datas\EnvData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * Solo stringhe: nessun test di questo file legge o scrive il vero .env.
 */
describe('EnvData::getLine', function (): void {
    test('escapes double quotes and backslashes inside the quoted value', function (): void {
        $line = (new EnvData)->getLine('MAIL_PASSWORD', 'a"b\\c');

        expect($line)->toBe('MAIL_PASSWORD="a\\"b\\\\c"'."\n");
    });

    test('leaves the dollar sign alone so ${APP_NAME} references keep working', function (): void {
        $line = (new EnvData)->getLine('MAIL_FROM_NAME', '${APP_NAME}');

        expect($line)->toBe('MAIL_FROM_NAME="${APP_NAME}"'."\n");
    });

    test('rejects values that contain a line break', function (string $value): void {
        expect(fn () => (new EnvData)->getLine('MAIL_HOST', $value))
            ->toThrow(\InvalidArgumentException::class);
    })->with([
        'newline' => ["x\nAPP_DEBUG=true"],
        'carriage return' => ["x\rAPP_DEBUG=true"],
    ]);

    test('writes booleans and integers unquoted', function (): void {
        $data = new EnvData;

        expect($data->getLine('DEBUGBAR_ENABLED', true))->toBe("DEBUGBAR_ENABLED=true\n")
            ->and($data->getLine('MAIL_PORT', 587))->toBe("MAIL_PORT=587\n");
    });
});

describe('EnvData::updateVar', function (): void {
    test('replaces only the line that starts with the key', function (): void {
        $env = "# MAIL_HOST=commented\nX_MAIL_HOST=other\nMAIL_HOST=\"old\"\nAPP_NAME=App\n";

        $updated = (new EnvData)->updateVar('mail_host', 'smtp.example.test', $env);

        expect($updated)->toBe("# MAIL_HOST=commented\nX_MAIL_HOST=other\nMAIL_HOST=\"smtp.example.test\"\nAPP_NAME=App\n");
    });

    test('does not read $1 or \\0 in the value as regex back-references', function (): void {
        $updated = (new EnvData)->updateVar('MAIL_PASSWORD', 'a$1b\\0c', "MAIL_PASSWORD=\"old\"\n");

        expect($updated)->toBe('MAIL_PASSWORD="a$1b\\\\0c"'."\n");
    });

    test('replaces the last line even without a trailing newline', function (): void {
        $updated = (new EnvData)->updateVar('APP_URL', 'http://example.test', "APP_NAME=App\nAPP_URL=\"http://old.test\"");

        expect($updated)->toBe("APP_NAME=App\nAPP_URL=\"http://example.test\"\n");
    });

    test('appends a missing key on its own line', function (string $env, string $expected): void {
        $updated = (new EnvData)->updateVar('SMS_DRIVER', 'netfun', $env);

        expect($updated)->toBe($expected);
    })->with([
        'with trailing newline' => ["APP_NAME=App\n", "APP_NAME=App\nSMS_DRIVER=\"netfun\"\n"],
        'without trailing newline' => ['APP_NAME=App', "APP_NAME=App\nSMS_DRIVER=\"netfun\"\n"],
        'empty file' => ['', "SMS_DRIVER=\"netfun\"\n"],
    ]);

    test('rejects a variable name that is not a plain identifier', function (string $key): void {
        expect(fn () => (new EnvData)->updateVar($key, 'x', "APP_NAME=App\n"))
            ->toThrow(\InvalidArgumentException::class);
    })->with([
        'newline in name' => ["a=1\nAPP_DEBUG"],
        'trailing newline' => ["APP_DEBUG\n"],
        'spaces' => ['app debug'],
        'regex characters' => ['app.*'],
    ]);
});
