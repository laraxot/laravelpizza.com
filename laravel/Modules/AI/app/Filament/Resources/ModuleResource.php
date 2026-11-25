<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Str;
use Modules\Xot\Models\Module;

class ModuleResource extends XotBaseResource
{
    protected static ?string $model = Module::class;

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        $prefix = static::class.'\\Pages\\';
        $name = Str::of(class_basename(static::class))->before('Resource')->toString();
        $plural = Str::of($name)->plural()->toString();
        $index = Str::of($prefix)->append('List'.$plural)->toString();
        $create = Str::of($prefix)->append('Create'.$name.'')->toString();
        $edit = Str::of($prefix)->append('Edit'.$name.'')->toString();

        /** @var class-string<Page> $index */
        $index = $index;
        /** @var class-string<Page> $create */
        $create = $create;
        /** @var class-string<Page> $edit */
        $edit = $edit;

        return [
            'index' => $index::route('/'),
            'create' => $create::route('/create'),
            'edit' => $edit::route('/{record}/edit'),
        ];
    }
}
