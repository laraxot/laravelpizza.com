<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Carbon;

/**
 * Email ricevuta dai webhook inbound (Postmark, Mailgun, SES).
 *
 * @property string $id
 * @property string $provider
 * @property string|null $message_id
 * @property string|null $from_email
 * @property string|null $from_name
 * @property string|null $to_email
 * @property string|null $subject
 * @property string|null $text_body
 * @property string|null $html_body
 * @property array<string, mixed>|null $headers
 * @property string|null $raw_path
 * @property array<string, mixed>|null $payload
 * @property Carbon|null $received_at
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|InboundEmail newModelQuery()
 * @method static Builder|InboundEmail newQuery()
 * @method static Builder|InboundEmail query()
 *
 * @mixin \Eloquent
 */
class InboundEmail extends BaseModel
{
    use HasUuids;

    public $incrementing = false;

    protected $table = 'inbound_emails';

    /** @var list<string> */
    protected $fillable = [
        'provider',
        'message_id',
        'from_email',
        'from_name',
        'to_email',
        'subject',
        'text_body',
        'html_body',
        'headers',
        'raw_path',
        'payload',
        'received_at',
        'status',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'headers' => 'array',
            'payload' => 'array',
            'received_at' => 'datetime',
        ];
    }
}
