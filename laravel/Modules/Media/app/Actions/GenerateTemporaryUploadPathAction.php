<?php

declare(strict_types=1);

namespace Modules\Media\Actions;

use Modules\Media\Models\Media;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

final class GenerateTemporaryUploadPathAction
{
    use QueueableAction;

    public function execute(Media $media, string $purpose = 'original'): string
    {
        $suffix = match ($purpose) {
            'conversion' => 'conversion',
            'responsive' => 'responsive',
            default => 'original',
        };

        $path = $this->getBasePath($media).'/'.md5($media->id.$media->uuid.$suffix);

        return $purpose === 'original' ? $path.'/' : $path;
    }

    public function getPath(Media $media): string
    {
        return $this->execute($media);
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->execute($media, 'conversion');
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->execute($media, 'responsive');
    }

    protected function getBasePath(Media $media): string
    {
        Assert::scalar($id = $media->getKey());
        $key = md5($media->uuid.$id);

        return "tmp/{$key}";
    }
}
