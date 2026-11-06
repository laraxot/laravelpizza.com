<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Support\Facades\File;

trait LogMutators
{
    public function getFileContentAttribute(?string $value): ?string
    {
        return $this->getFileContent();
    }

    public function getFileContent(): string
    {
        return File::get(storage_path('logs/'.$this->id.'.log'));
    }
}
