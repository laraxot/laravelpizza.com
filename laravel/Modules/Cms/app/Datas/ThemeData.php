<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class ThemeData extends Data
{
    public string $name; // ": "MaterialBlog",

    public string $type = 'pub';

    public string $description = '';

    public array $keywords = [];

    public bool $active = true;

    public int $order = 0;

    public array $aliases = [];

    public array $files = [];

    public array $requires = [];
}
