<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder;

test('DownloadAttachmentPlaceHolder extends XotBasePlaceholder', function () {
    expect(is_a(DownloadAttachmentPlaceHolder::class, Modules\Xot\Filament\Forms\Components\XotBasePlaceholder::class, true))->toBeTrue();
});

test('DownloadAttachmentPlaceHolder has setUp method', function () {
    expect(method_exists(DownloadAttachmentPlaceHolder::class, 'setUp'))->toBeTrue();
});

test('DownloadAttachmentPlaceHolder has generateContent method', function () {
    expect(method_exists(DownloadAttachmentPlaceHolder::class, 'generateContent'))->toBeTrue();
});
