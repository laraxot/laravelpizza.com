<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Modules\User\Filament\Resources\ClientResource\Pages\CreateClient;
use Modules\User\Filament\Resources\ClientResource\Pages\EditClient;
use Modules\User\Filament\Resources\ClientResource\Pages\ListClients;
use Modules\User\Filament\Resources\ClientResource\Pages\ViewClient;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Webmozart\Assert\Assert;

class ClientResource extends XotBaseResource
{
    protected static string $resource = ClientResource::class;
    // use HasResourceFormComponents;

    /**
     * Get the model class for the resource from Passport.
     *
     * @return class-string<Model>
     */
    /**
     * @return class-string<Model>
     */
    public static function getModel(): string
    {
        $model = Passport::clientModel();
        if (! class_exists($model)) {
            return Client::class;
        }

        Assert::subclassOf($model, Model::class);

        /* @var class-string<Model> $model */
        return $model;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClients::route('/'),
            'view' => ViewClient::route('/{record}'),
            'edit' => EditClient::route('/{record}/edit'),
            'create' => CreateClient::route('/create'),
        ];
    }

    /**
     * Check if resource form components are enabled.
     */
    protected static function isResourceFormComponentsEnabled(): bool
    {
        return false;
    }

    /**
     * Get resource form components.
     *
     * @return array<int, never>
     */
    protected static function getResourceFormComponents(): array
    {
        return [];
    }
}
