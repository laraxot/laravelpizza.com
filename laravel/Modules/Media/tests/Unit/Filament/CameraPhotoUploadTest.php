<?php

declare(strict_types=1);

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\Media\Filament\Forms\Components\CameraPhotoUpload;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-media-db');

/*
 * Una foto da telefono (3-10 MB) superava il limite di 2 MB per richiesta del server (413 su /livewire/upload-file).
 * FilePond la riduce nel browser prima dell'upload: 9,9 MB diventano 1,5 MB a 1920 px (misura in docs/camera-photo-upload-research.md).
 */
it('shrinks camera photos in the browser before they are uploaded', function (): void {
    $field = CameraPhotoUpload::make('images');

    Assert::assertInstanceOf(SpatieMediaLibraryFileUpload::class, $field);
    Assert::assertSame((string) CameraPhotoUpload::MAX_SIDE, $field->getAutomaticallyResizeImagesWidth());
    Assert::assertSame((string) CameraPhotoUpload::MAX_SIDE, $field->getAutomaticallyResizeImagesHeight());
    Assert::assertSame('contain', $field->getAutomaticallyResizeImagesMode());
    Assert::assertFalse($field->shouldAutomaticallyUpscaleImagesWhenResizing());
});

it('lets a field choose its own size', function (): void {
    $field = CameraPhotoUpload::make('images')->automaticallyResizeImagesToWidth('1280')->automaticallyResizeImagesToHeight('1280');

    Assert::assertSame('1280', $field->getAutomaticallyResizeImagesWidth());
});
