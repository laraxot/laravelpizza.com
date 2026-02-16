<?php

/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource.php
 * @see https://github.com/3x1io/filament-user/blob/main/src/resources/UserResource.php
 */

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Carbon\CarbonInterface;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseUserResource extends XotBaseResource
{
    // protected static ?string $model = \Modules\Xot\Datas\XotData::make()->getUserClass();

    // Static property Modules\User\Filament\Resources\UserResource::$enablePasswordUpdates is never read, only written.
    // private static bool|\Closure $enablePasswordUpdates = true;

    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    // public static function extendForm(\Closure $callback): void
    // {
    //    static::$extendFormCallback = $callback;
    // }

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'section01' => Section::make([
                'name' => TextInput::make('name')->required(),
                'email' => TextInput::make('email')->required()->unique(ignoreRecord: true),
                'password' => TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(function ($state) {
                        if (empty($state)) {
                            return;
                        }

                        return is_string($state) ? Hash::make($state) : null;
                    })
                    ->required(fn ($livewire) => $livewire instanceof CreateUser),
            ])->columnSpan(8),
            'section02' => Section::make([
                'created_at' => Placeholder::make('created_at')->content(static function ($record) {
                    if ($record === null || ! $record instanceof Model) {
                        return new HtmlString('&mdash;');
                    }

                    if (! isset($record->created_at) || ! ($record->created_at instanceof \DateTimeInterface)) {
                        return new HtmlString('&mdash;');
                    }

                    $createdAt = $record->created_at;

                    return $createdAt instanceof CarbonInterface ? $createdAt->diffForHumans() : $createdAt->format('Y-m-d H:i:s');
                }),
            ])->columnSpan(4),
        ];
    }

    // public static function enablePasswordUpdates(bool|Closure $condition = true): void
    // {
    //     static::$enablePasswordUpdates = $condition;
    // }

    /*
     * public static function getModel(): string
     * {
     * return config('filament-user-resource.model');
     * }
     */

    #[\Override]
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
