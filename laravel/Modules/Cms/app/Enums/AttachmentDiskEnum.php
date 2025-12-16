<?php

declare(strict_types=1);

namespace Modules\Cms\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

enum AttachmentDiskEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case public_html = 'public_html';
    case videos = 'videos';
    case local = 'local';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }
}
