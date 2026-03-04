<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources;

use Filament\Schemas\Components\Wizard\Step;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ProbeResource extends XotBaseResource
{
    protected static ?string $model = null;

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function getCustomStepSchema(): array
    {
        return ['ok'];
    }

    public static function callGetKeyTrans(string $key): string
    {
        return static::getKeyTrans($key);
    }

    public static function callGetStepByName(string $name): Step
    {
        return static::getStepByName($name);
    }

    public static function resetModelCache(): void
    {
        static::$model = null;
    }
}

namespace Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource\Pages;

use Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource;

class ListProbes extends Page
{
    protected static string $resource = ProbeResource::class;
}

class CreateProbe extends Page
{
    protected static string $resource = ProbeResource::class;
}

class EditProbe extends Page
{
    protected static string $resource = ProbeResource::class;
}

class ViewProbe extends Page
{
    protected static string $resource = ProbeResource::class;
}
