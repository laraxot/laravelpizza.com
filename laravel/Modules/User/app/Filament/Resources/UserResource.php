<?php

/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource.php
 * @see https://github.com/3x1io/filament-user/blob/main/src/resources/UserResource.php
 */

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\RelationManagers\AuthenticationLogsRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\ClientsRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\OauthTokensRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\SocialiteUsersRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\TenantsRelationManager;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
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
                    ->dehydrateStateUsing(function ($state): ?string {
                        // Type narrowing for PHPStan Level 10
                        if (! is_string($state) || empty($state)) {
                            return null;
                        }

                        return Hash::make($state);
                    })
                    ->required(fn ($livewire) => $livewire instanceof CreateUser),
            ])->columnSpan(8),
            'section02' => Section::make([
                'created_at' => Placeholder::make('created_at')->content(static function ($record) {
                    // Type narrowing for PHPStan Level 10
                    if (! $record instanceof Model) {
                        return new HtmlString('&mdash;');
                    }

                    // PHPStan Level 10: hasAttribute() invece di property_exists() per Eloquent
                    if (! $record->hasAttribute('created_at')) {
                        return new HtmlString('&mdash;');
                    }

                    /** @var Carbon|null $createdAt */
                    $createdAt = $record->getAttribute('created_at');

                    if (null === $createdAt) {
                        return new HtmlString('&mdash;');
                    }
                    if ($createdAt instanceof CarbonInterface) {
                        return $createdAt->diffForHumans();
                    }
                    if ($createdAt instanceof \DateTimeInterface) {
                        return $createdAt->format('Y-m-d H:i:s');
                    }

                    return new HtmlString('&mdash;');
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

    /**
     * Get the model class name for this resource.
     *
     * @return class-string<Model>
     */
    #[\Override]
    public static function getModel(): string
    {
        $xot = XotData::make();

        /* @var class-string<Model> */
        return $xot->getUserClass();
    }

    /**
     * Get the relations available for the resource.
     *
     * @return array<int, class-string<RelationManager>>
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [
            AuthenticationLogsRelationManager::class,
            OauthTokensRelationManager::class,
            SocialiteUsersRelationManager::class,
            ClientsRelationManager::class,
            TenantsRelationManager::class,
        ];
    }
}
