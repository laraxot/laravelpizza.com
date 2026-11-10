<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Meetup\Models\Performer.
 *
 * Represents speakers, entertainers, and other performers at events.
 *
 * @property string $id
 * @property string $name
 * @property string|null $type
 * @property string|null $bio
 * @property string|null $photo
 * @property string|null $website
 * @property string|null $email
 * @property string|null $company
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property string|null $github
 * @property array<string, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder<Performer> newModelQuery()
 * @method static Builder<Performer> newQuery()
 * @method static Builder<Performer> query()
 * @method static Builder<Performer> byType(string $type)
 *
 * @property string|null $user_id
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read EventPerformer|null $pivot
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read ProfileContract|null $updater
 *
 * @method static \Modules\Meetup\Database\Factories\PerformerFactory factory($count = null, $state = [])
 * @method static Builder<static>|Performer whereBio($value)
 * @method static Builder<static>|Performer whereCompany($value)
 * @method static Builder<static>|Performer whereCreatedAt($value)
 * @method static Builder<static>|Performer whereCreatedBy($value)
 * @method static Builder<static>|Performer whereEmail($value)
 * @method static Builder<static>|Performer whereGithub($value)
 * @method static Builder<static>|Performer whereId($value)
 * @method static Builder<static>|Performer whereLinkedin($value)
 * @method static Builder<static>|Performer whereMetaData($value)
 * @method static Builder<static>|Performer whereName($value)
 * @method static Builder<static>|Performer wherePhoto($value)
 * @method static Builder<static>|Performer whereTwitter($value)
 * @method static Builder<static>|Performer whereType($value)
 * @method static Builder<static>|Performer whereUpdatedAt($value)
 * @method static Builder<static>|Performer whereUpdatedBy($value)
 * @method static Builder<static>|Performer whereUserId($value)
 * @method static Builder<static>|Performer whereWebsite($value)
 *
 * @mixin \Eloquent
 */
class Performer extends BaseModel
{
    protected static function booted(): void
    {
        // Le tabelle pivot non hanno foreign key con cascade: i collegamenti agli eventi vanno tolti qui.
        static::deleting(static function (self $performer): void {
            EventPerformer::query()->where('performer_id', $performer->getKey())->delete();
        });
    }

    /** @var list<string> */
    protected $fillable = [
        'name',
        'type',
        'bio',
        'photo',
        'website',
        'email',
        'company',
        'twitter',
        'linkedin',
        'github',
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
     * Get events where this performer is scheduled.
     *
     * @return BelongsToMany<Event, $this, EventPerformer, 'pivot'>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToManyX(Event::class, 'event_performer')
            ->withPivot(['role', 'order'])
            ->using(EventPerformer::class)
            ->withTimestamps();
    }

    /**
     * Scope: filter by performer type.
     *
     * @param  Builder<Performer>  $query
     * @return Builder<Performer>
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Generate Schema.org Person JSON-LD structured data.
     *
     * @see https://schema.org/Person
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        $data = [
            '@type' => 'Person',
            'name' => $this->name,
        ];

        if ($this->bio !== null) {
            $data['description'] = $this->bio;
        }

        if ($this->photo !== null) {
            $data['image'] = asset($this->photo);
        }

        if ($this->website !== null) {
            $data['url'] = $this->website;
        }

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }

        if ($this->company !== null) {
            $data['affiliation'] = [
                '@type' => 'Organization',
                'name' => $this->company,
            ];
        }

        if ($this->type !== null) {
            $data['jobTitle'] = $this->type;
        }

        // Social links as sameAs
        $sameAs = array_values(array_filter([
            $this->twitter,
            $this->linkedin,
            $this->github,
        ]));

        if ($sameAs !== []) {
            $data['sameAs'] = $sameAs;
        }

        return $data;
    }
}
