<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery;
use Modules\Rating\Models\Like;
use Modules\Rating\Models\Traits\HasLikes;

/**
 * Stub model with HasLikes trait for testing.
 */
final class LikeableStub extends Model
{
    use HasLikes;

    protected $table = 'likeable_stub';

    /** @var MorphMany<Like, $this>|null */
    public ?MorphMany $mockLikesRelation = null;

    /** @return MorphMany<Like, $this> */
    public function likesRelation(): MorphMany
    {
        if ($this->mockLikesRelation instanceof MorphMany) {
            return $this->mockLikesRelation;
        }

        /** @var MorphMany<Like, $this>&Mockery\MockInterface $fallback */
        $fallback = Mockery::mock(MorphMany::class);
        $fallback->shouldReceive('delete')->andReturn(0);

        return $fallback;
    }
}
