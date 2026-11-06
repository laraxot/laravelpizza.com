<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Notify\Models\NotificationTemplate;

trait NotificationTemplateVersionRelations
{
    /**
     * @phpstan-return BelongsTo<NotificationTemplate, $this>
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }
}
