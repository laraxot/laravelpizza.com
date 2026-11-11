<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Modules\Notify\Models\Contact.
 *
 * @property-read ProfileContract|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|Contact newModelQuery()
 * @method static Builder<static>|Contact newQuery()
 * @method static Builder<static>|Contact query()
 *
 * @property string $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $contact_type
 * @property string|null $value
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $user_id
 * @property string|null $verified_at
 * @property string|null $token
 * @property int|null $sms_count
 * @property string|null $sms_status_code
 * @property string|null $sms_status_txt
 * @property Carbon|null $sms_sent_at
 * @property Carbon|null $mail_sent_at
 * @property int|null $mail_count
 * @property int|null $usesleft
 * @property int|null $order_column
 * @property int|null $duplicate_count
 * @property string|null $attribute_1
 * @property string|null $attribute_2
 * @property string|null $attribute_3
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|Contact whereContactType($value)
 * @method static Builder<static>|Contact whereCreatedAt($value)
 * @method static Builder<static>|Contact whereCreatedBy($value)
 * @method static Builder<static>|Contact whereDeletedAt($value)
 * @method static Builder<static>|Contact whereDeletedBy($value)
 * @method static Builder<static>|Contact whereId($value)
 * @method static Builder<static>|Contact whereModelId($value)
 * @method static Builder<static>|Contact whereModelType($value)
 * @method static Builder<static>|Contact whereToken($value)
 * @method static Builder<static>|Contact whereUpdatedAt($value)
 * @method static Builder<static>|Contact whereUpdatedBy($value)
 * @method static Builder<static>|Contact whereUserId($value)
 * @method static Builder<static>|Contact whereValue($value)
 * @method static Builder<static>|Contact whereVerifiedAt($value)
 *
 * @mixin Model
 */
class Contact extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'model_id',
        'model_type',
        'contact_type',
        'value',
        'verified_at',
        'updated_at',
        'created_at',
        'updated_by',
        'created_by',
        'user_id',
        'token',
        'first_name',
        'last_name',
        'sms_sent_at',
        'sms_count',
        'mail_sent_at',
        'mail_count',
        'sms_status_code',
        'sms_status_txt',
        'usesleft',
        'order_column',
        'duplicate_count',
        'attribute_1',
        'attribute_2',
        'attribute_3',
        'attribute_4',
        'attribute_5',
        'attribute_6',
        'attribute_7',
        'attribute_8',
        'attribute_9',
        'attribute_10',
        'attribute_11',
        'attribute_12',
        'attribute_13',
        'attribute_14'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            // 'date_start' => 'datetime:Y-m-d\TH:i',
            // 'date_end' => 'datetime:Y-m-d\TH:i',
            'model_id' => 'string',
            'user_id' => 'string',
            'mail_sent_at' => 'datetime',
            'sms_sent_at' => 'datetime'];
    }
}
