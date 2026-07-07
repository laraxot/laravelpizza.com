<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Modules\Media\Database\Factories\MediaFactory;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('can create media with minimal data', function (): void {
    $media = MediaFactory::new()->createOne([
        'model_type' => 'Modules\User\Models\User',
        'model_id' => '1',
        'collection_name' => 'avatars',
        'name' => 'test-image',
        'file_name' => 'test-image.jpg',
        'disk' => 'public',
        'size' => 1024,
    ]);

    Assert::assertInstanceOf(Media::class, $media);

    /** @var TestCase $this */
    $this->assertMediaTableHas('media', [
        'id' => (int) $media->getKey(),
        'collection_name' => 'avatars',
        'name' => 'test-image',
        'file_name' => 'test-image.jpg',
        'disk' => 'public',
        'size' => 1024,
    ]);
});
