<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\NotifyTheme;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NotifyThemeResource extends XotBaseResource
{
    protected static ?string $model = NotifyTheme::class;

    /**
     * @return array<string, string>
     */
    public static function fieldOptions(string $field): array
    {
        return match ($field) {
            'lang' => [
                'it' => 'Italiano',
                'en' => 'English'],
            'type' => [
                'email' => 'Email',
                'sms' => 'SMS',
                'push' => 'Push Notification'],
            'post_type' => [
                'page' => 'Page',
                'post' => 'Post',
                'product' => 'Product'],
            default => [],
        };
    }
}
