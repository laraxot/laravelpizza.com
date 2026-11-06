<?php

declare(strict_types=1);

namespace Modules\Media\Actions\TemporaryUpload;

use Modules\Media\Models\Media;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Genera il path per le immagini responsive di un upload temporaneo.
 */
final class GetTemporaryUploadResponsivePathAction
{
    use QueueableAction;

    public function execute(Media $media): string
    {
        Assert::string($id = $media->getKey());
        $key = md5($media->uuid.$id);

        return "tmp/{$key}/".md5($media->id.$media->uuid.'responsive');
    }
}
