<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

// use Modules\Notify\Datas\BeautyEmailViewData;

class BeautyEmailData extends Data
{
    public string $view;

    // css must not be accessed before its inizialization.
    // sulla config beautymail di localhost manca, quindi va gestito se è vuoto
    /** @var array<string, mixed>|null */
    public ?array $css = [];

    /** @var array<string, string> */
    public array $colors;
}
