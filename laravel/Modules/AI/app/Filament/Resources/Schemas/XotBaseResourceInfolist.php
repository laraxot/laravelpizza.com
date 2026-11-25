<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Modules\Xot\Filament\Traits\HasXotInfolist;
use Webmozart\Assert\Assert;

abstract class XotBaseResourceInfolist
{
    use HasXotInfolist;

    public static function configure(Schema $schema): Schema
    {
        if (static::class === self::class) {
            throw new \LogicException('XotBaseResourceInfolist::configure() must be called on a concrete infolist class.');
        }

        $instance = app(static::class);
        Assert::isInstanceOf($instance, self::class);

        return $instance->infolist($schema);
    }

    /**
     * @return array<string, Component>
     */
    abstract public function getInfolistSchema(): array;
}
