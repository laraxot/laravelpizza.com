<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Override;

/**
 * @method static Builder<static>|NotificationType newModelQuery()
 * @method static Builder<static>|NotificationType newQuery()
 * @method static Builder<static>|NotificationType query()
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $category
 * @property bool $is_active
 * @property array<string, array<string, mixed>>|null $channels
 * @property array<string, mixed>|null $settings
 * @property array<string, mixed>|null $metrics
 * @property array<string, mixed>|null $scheduling
 * @property array<string, mixed>|null $rules
 * @property array<string, mixed>|null $permissions
 * @property string|null $display_name
 * @property array<string, mixed>|null $templates
 * @property array<string, mixed>|null $integrations
 * @property array<string, mixed>|null $delivery_rules
 * @property string|null $template
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static Builder<static>|NotificationType whereCreatedAt($value)
 * @method static Builder<static>|NotificationType whereCreatedBy($value)
 * @method static Builder<static>|NotificationType whereDescription($value)
 * @method static Builder<static>|NotificationType whereId($value)
 * @method static Builder<static>|NotificationType whereName($value)
 * @method static Builder<static>|NotificationType whereTemplate($value)
 * @method static Builder<static>|NotificationType whereUpdatedAt($value)
 * @method static Builder<static>|NotificationType whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class NotificationType extends Model
{
    /** @use HasFactory<\Modules\Notify\Database\Factories\NotificationTypeFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'is_active',
        'channels',
        'settings',
        'template',
    ];

    /** @return array<string, string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'channels' => 'array',
            'settings' => 'array',
        ];
    }
}
