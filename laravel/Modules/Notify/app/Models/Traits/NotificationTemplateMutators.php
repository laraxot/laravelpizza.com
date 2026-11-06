<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

use Modules\Xot\Actions\Cast\SafeStringCastAction;

trait NotificationTemplateMutators
{
    public function getChannelsLabelAttribute(): string
    {
        return $this->getChannelsLabel();
    }

    public function getChannelsLabel(): string
    {
        $channels = $this->channels;
        if (! is_array($channels)) {
            return '';
        }

        return collect($channels)
            ->filter(is_string(...))
            ->map(fn (string $channel): string => SafeStringCastAction::cast(__('notify::template.fields.channel.options.'.$channel.'.label')))
            ->implode(', ');
    }
}
