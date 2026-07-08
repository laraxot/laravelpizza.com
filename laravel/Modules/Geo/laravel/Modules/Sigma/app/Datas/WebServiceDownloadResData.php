<?php

declare(strict_types=1);

namespace Modules\Sigma\Datas;

use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class WebServiceDownloadResData extends Data
{
    public string $filename;

    public string $disk;

    public string $message;
}
