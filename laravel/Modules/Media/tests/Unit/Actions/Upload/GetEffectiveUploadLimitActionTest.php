<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Upload;

use Modules\Media\Actions\Upload\GetEffectiveUploadLimitAction;
use Modules\Media\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

uses(TestCase::class)->group('no-media-db');

/*
 * Una foto da fotocamera (3-15 MB) falliva con `validation.uploaded` perche' il campo prometteva 10 MB mentre il PHP del web server ne
 * accettava 2. Il limite che il browser deve rispettare e' il piu' piccolo tra PHP, regola Livewire e campo, letto dentro la richiesta
 * web (stesso `php.ini` che riceve l'upload), mai dal CLI.
 */
describe('GetEffectiveUploadLimitAction', function (): void {
    it('never promises more than the PHP runtime accepts', function (): void {
        $phpBytes = (int) floor(UploadedFile::getMaxFilesize() * 0.9);

        expect(app(GetEffectiveUploadLimitAction::class)->execute())->toBeLessThanOrEqual($phpBytes);
    });

    it('keeps headroom for the multipart envelope', function (): void {
        expect(app(GetEffectiveUploadLimitAction::class)->execute())->toBeLessThan((int) UploadedFile::getMaxFilesize());
    });

    it('honours a field limit smaller than the runtime', function (): void {
        expect(app(GetEffectiveUploadLimitAction::class)->execute(1))->toBe(1024);
    });

    it('ignores a field limit larger than the runtime', function (): void {
        $action = app(GetEffectiveUploadLimitAction::class);

        expect($action->execute(10_000_000))->toBe($action->execute());
    });

    it('honours the Livewire temporary upload rule', function (mixed $rules, int $expectedBytes): void {
        config(['livewire.temporary_file_upload.rules' => $rules]);

        expect(app(GetEffectiveUploadLimitAction::class)->execute())->toBe($expectedBytes);
    })->with([
        'array of rules' => [['required', 'file', 'max:50'], 50 * 1024],
        'pipe string' => ['required|file|max:50', 50 * 1024],
    ]);

    it('falls back to the Livewire default of 12 MB when no rule is configured', function (): void {
        config(['livewire.temporary_file_upload.rules' => null]);

        expect(app(GetEffectiveUploadLimitAction::class)->execute())->toBeLessThanOrEqual(12288 * 1024);
    });
});
