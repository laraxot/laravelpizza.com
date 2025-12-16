<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class AttachmentData extends Data
{
    public string $path;

    public string $as;

    public string $mime;
}
