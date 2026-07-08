<?php

declare(strict_types=1);

namespace Modules\UI\Datas;

use Spatie\LaravelData\Data;

final class SliderData extends Data
{
    public function __construct(
        public ?string $desktop_thumbnail,
        public ?string $mobile_thumbnail,
        public ?string $desktop_thumbnail_webp,
        public ?string $mobile_thumbnail_webp,
        public ?string $link,
        public ?string $title,
        public ?string $short_description,
        public ?string $description,
        public ?string $action_text,
    ) {
        $this->short_description = $this->description;
    }
}
