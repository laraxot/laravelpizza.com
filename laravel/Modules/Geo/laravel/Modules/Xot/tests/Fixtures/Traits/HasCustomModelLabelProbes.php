<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Traits;

use Modules\Xot\Traits\Filament\HasCustomModelLabel;

abstract class HasCustomModelLabelProbeBase
{
    use HasCustomModelLabel;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    protected static ?string $navigationLabel = null;

    public static function getModel(): string
    {
        return 'App\Models\User';
    }
}

class ModelLabelFromPropertyProbe extends HasCustomModelLabelProbeBase
{
    protected static ?string $modelLabel = 'Custom Label';
}

class ModelLabelFromModelNameProbe extends HasCustomModelLabelProbeBase
{
    public static function getModel(): string
    {
        return 'App\Models\UserInvitation';
    }
}

class PluralModelLabelFromPropertyProbe extends HasCustomModelLabelProbeBase
{
    protected static ?string $pluralModelLabel = 'Plural Labels';

    public static function getModelLabel(): string
    {
        return 'Label';
    }
}

class PluralModelLabelFromSingularProbe extends HasCustomModelLabelProbeBase
{
    public static function getModelLabel(): string
    {
        return 'Category';
    }
}

class NavigationLabelFromPropertyProbe extends HasCustomModelLabelProbeBase
{
    protected static ?string $navigationLabel = 'Nav Label';

    public static function getPluralModelLabel(): string
    {
        return 'Plurals';
    }
}

class NavigationLabelFromPluralProbe extends HasCustomModelLabelProbeBase
{
    public static function getPluralModelLabel(): string
    {
        return 'Plurals';
    }
}

class BreadcrumbProbe extends HasCustomModelLabelProbeBase
{
    public static function getModelLabel(): string
    {
        return 'Bread';
    }
}
