<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class NotifyThemeData extends Data
{
    public ?string $from_email = null; // from address

    public ?string $from = null; // from name

    public string $subject;

    public string $body_html;

    /**
     * @var array<string, mixed>
     */
    public array $view_params = [];
}
