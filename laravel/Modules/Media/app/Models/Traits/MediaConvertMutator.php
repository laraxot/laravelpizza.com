<?php

declare(strict_types=1);

namespace Modules\Media\Models\Traits;

use Modules\Media\Models\MediaConvert;

/**
 * Mutator + gemelli di {@see MediaConvert}.
 *
 * Ogni `get{X}Attribute()` delega a `get{X}()` nello stesso file
 * (regola accessor-twin: cache/persistenza nell'accessor, calcolo puro nel gemello).
 *
 * @phpstan-require-extends MediaConvert
 */
trait MediaConvertMutator
{
    public function getDiskAttribute(?string $value): ?string
    {
        return $this->getDisk();
    }

    public function getDisk(): ?string
    {
        if ($this->media === null) {
            return null;
        }

        return $this->media->disk;
    }

    public function getFileAttribute(?string $value): ?string
    {
        return $this->getFile();
    }

    public function getFile(): ?string
    {
        if ($this->media === null) {
            return null;
        }

        return $this->media->path.'/'.$this->media->file_name;
    }

    public function getConvertedFileAttribute(?string $value): ?string
    {
        return $this->getConvertedFile();
    }

    public function getConvertedFile(): ?string
    {
        if ($this->media === null) {
            return null;
        }
        $info = pathinfo($this->media->file_name);
        // "dirname" => "."
        // "basename" => "20600550-uhd_3840_2160_30fps.mp4"
        // "extension" => "mp4"
        // "filename" => "20600550-uhd_3840_2160_30fps"

        return $this->media->path.'/conversions/'.$info['filename'].'_'.$this->id.'.'.$this->format;
    }
}
