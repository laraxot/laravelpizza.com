<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Meetup\Models\Sponsor.
 *
 * Represents companies or organizations sponsoring events.
 *
 * @property string $id
 * @property string $name
 * @property string|null $level
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $description
 * @property string|null $email
 * @property string|null $contact_person
 * @property array<array-key, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<Sponsor> newModelQuery()
 * @method static Builder<Sponsor> newQuery()
 * @method static Builder<Sponsor> query()
 *
 * @property string|null $contact_email
 * @property string|null $contact_name
 * @property int|null $order
 * @property string|null $user_id
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read EventSponsor|null $pivot
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read ProfileContract|null $updater
 *
 * @method static \Modules\Meetup\Database\Factories\SponsorFactory factory($count = null, $state = [])
 * @method static Builder<static>|Sponsor whereContactEmail($value)
 * @method static Builder<static>|Sponsor whereContactName($value)
 * @method static Builder<static>|Sponsor whereCreatedAt($value)
 * @method static Builder<static>|Sponsor whereCreatedBy($value)
 * @method static Builder<static>|Sponsor whereDescription($value)
 * @method static Builder<static>|Sponsor whereId($value)
 * @method static Builder<static>|Sponsor whereLevel($value)
 * @method static Builder<static>|Sponsor whereLogo($value)
 * @method static Builder<static>|Sponsor whereMetaData($value)
 * @method static Builder<static>|Sponsor whereName($value)
 * @method static Builder<static>|Sponsor whereOrder($value)
 * @method static Builder<static>|Sponsor whereUpdatedAt($value)
 * @method static Builder<static>|Sponsor whereUpdatedBy($value)
 * @method static Builder<static>|Sponsor whereUserId($value)
 * @method static Builder<static>|Sponsor whereWebsite($value)
 *
 * @mixin \Eloquent
 */
class Sponsor extends BaseModel
{
    protected static function booted(): void
    {
        // Le tabelle pivot non hanno foreign key con cascade: i collegamenti agli eventi vanno tolti qui.
        static::deleting(static function (self $sponsor): void {
            EventSponsor::query()->where('sponsor_id', $sponsor->getKey())->delete();
        });
    }

    /** @var list<string> */
    protected $fillable = [
        'name',
        'level',
        'website',
        'logo',
        'description',
        'contact_email',
        'contact_name',
        'order',
        'meta_data',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta_data' => 'array',
        ];
    }

    /**
     * Get events where this sponsor is linked.
     *
     * @return BelongsToMany<Event, $this>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToManyX(Event::class, 'event_sponsor')->withTimestamps();
    }

    /**
     * Generate Schema.org Organization JSON-LD structured data.
     *
     * @see https://schema.org/Organization
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        $data = [
            '@type' => 'Organization',
            'name' => $this->name,
        ];

        if ($this->website !== null) {
            $data['url'] = $this->website;
        }

        if ($this->logo !== null) {
            $data['logo'] = asset($this->logo);
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }

        if ($this->contact_person !== null) {
            $data['contactPoint'] = [
                '@type' => 'ContactPoint',
                'contactType' => 'sponsor contact',
                'name' => $this->contact_person,
            ];
        }

        return $data;
    }
}
