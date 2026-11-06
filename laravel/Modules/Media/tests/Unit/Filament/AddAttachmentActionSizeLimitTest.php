<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Filament;

use Filament\Forms\Components\FileUpload;
use Modules\Media\Datas\MediaConfigData;
use Modules\Media\Filament\Actions\AddAttachmentAction;
use Modules\Media\Filament\Resources\HasMediaResource\Actions\AddAttachmentAction as HasMediaAddAttachmentAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Filament `maxSize()` takes kilobytes. `media-library.max_file_size` is in bytes (10 MB = 10485760),
 * so passing it straight through allowed about 10 GB. The limit must come from the Media SettingPage.
 */
dataset('add attachment action classes', [
    'Actions\AddAttachmentAction' => [AddAttachmentAction::class],
    'HasMediaResource\Actions\AddAttachmentAction' => [HasMediaAddAttachmentAction::class],
]);

function addAttachmentUploadField(string $action): FileUpload
{
    $schema = $action === AddAttachmentAction::class
        ? AddAttachmentAction::getFormSchema(false)
        : HasMediaAddAttachmentAction::getFormSchema(false);
    $upload = $schema[0];
    Assert::assertInstanceOf(FileUpload::class, $upload);

    return $upload;
}

it('limits the upload to the size saved in the Media settings, in kilobytes', function (string $action): void {
    // Arrange
    config(['media-library.max_file_size' => 1024 * 1024 * 10]);
    $expectedKb = MediaConfigData::make()->attachment_max_size_kb;

    // Act
    $upload = addAttachmentUploadField($action);

    // Assert
    expect($upload->getMaxSize())->toBe($expectedKb);
})->with('add attachment action classes');

it('does not read the byte limit of the media library package', function (string $action): void {
    // Arrange
    config(['media-library.max_file_size' => 1024 * 1024 * 1024]);

    // Act
    $upload = addAttachmentUploadField($action);

    // Assert
    expect($upload->getMaxSize())->toBeLessThan(1024 * 1024);
})->with('add attachment action classes');
