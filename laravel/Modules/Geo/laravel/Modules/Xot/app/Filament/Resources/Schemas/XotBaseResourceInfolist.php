<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

abstract class XotBaseResourceInfolist
{
    final public static function configure(Schema $schema): Schema
    {
        return $schema->components(static::getInfolistSchema());
    }

    /**
     * @return array<string, Component>
     */
    abstract public static function getInfolistSchema(): array;
}
