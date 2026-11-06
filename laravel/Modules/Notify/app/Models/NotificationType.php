<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Database\Factories\NotificationTypeFactory;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $category
 * @property bool $is_active
 * @property array<string, mixed>|null $channels
 * @property array<string, mixed>|null $settings
 * @property string|null $template
 *
 * @method static Builder<static>|NotificationType newModelQuery()
 * @method static Builder<static>|NotificationType newQuery()
 * @method static Builder<static>|NotificationType query()
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class NotificationType extends Model
{
    /** @use HasFactory<NotificationTypeFactory> */
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
        'template'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'channels' => 'array',
            'settings' => 'array'];
    }
}
