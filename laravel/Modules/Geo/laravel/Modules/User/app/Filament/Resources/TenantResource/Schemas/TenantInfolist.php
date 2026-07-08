<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TenantInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati su Model Tenant.php -> id, name, slug, email_address, phone, mobile, address, primary_color, secondary_color, domain, database, is_active, trial_ends_at, settings
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'slug' => TextEntry::make('slug'),
            'domain' => TextEntry::make('domain'),
            'email_address' => TextEntry::make('email_address'),
            'phone' => TextEntry::make('phone'),
            'mobile' => TextEntry::make('mobile'),
            'address' => TextEntry::make('address'),
            'primary_color' => TextEntry::make('primary_color'),
            'secondary_color' => TextEntry::make('secondary_color'),
            'is_active' => TextEntry::make('is_active')
                ->badge(),
            'trial_ends_at' => TextEntry::make('trial_ends_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
