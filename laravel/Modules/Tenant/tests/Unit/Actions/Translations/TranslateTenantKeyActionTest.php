<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Translations;

use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    $directory = storage_path('tests/tenant-lang/en');
    File::deleteDirectory(dirname($directory));
    File::makeDirectory($directory, 0755, true, true);
    TestCase::$testDirectory = dirname($directory);

    File::put(
        $directory.'/messages.php',
        "<?php return ['welcome' => 'Welcome to Tenant!'];"
    );

    app()->setLocale('en');

    $messagesPath = $directory.'/messages.php';
    $mock = Mockery::mock(GetTenantFilePathAction::class);
    // allows(['execute' => $closure]) restituirebbe la closure; andReturnUsing la esegue.
    TestCase::expectMockery($mock, 'execute')->andReturnUsing(
        static function (string $filename) use ($messagesPath): string {
            if ($filename === 'lang/en/messages.php') {
                return $messagesPath;
            }

            return dirname($messagesPath).'/'.$filename;
        }
    );
    app()->instance(GetTenantFilePathAction::class, $mock);

    $this->action = app(TranslateTenantKeyAction::class);
});

afterEach(function (): void {
    File::deleteDirectory(TestCase::$testDirectory);
    Mockery::close();
});

describe('TranslateTenantKeyAction', function (): void {
    it('translates key from tenant lang files', function (): void {
        /** @var TranslateTenantKeyAction $action */
        $action = $this->action;
        $translation = $action->execute('messages.welcome');

        Assert::assertSame('Welcome to Tenant!', $translation);
    });

    it('returns key if translation file is missing', function (): void {
        /** @var TranslateTenantKeyAction $action */
        $action = $this->action;
        $translation = $action->execute('missing.key');

        Assert::assertSame('missing.key', $translation);
    });
});
