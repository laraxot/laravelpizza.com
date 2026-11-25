<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery;
use Modules\Rating\Models\Like;
use Modules\Rating\Tests\Fixtures\LikeableNativeRelationStub;
use Modules\Rating\Tests\Fixtures\LikeableStub;
use Modules\Rating\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('HasLikes', function (): void {
    test('likedBy e dislikedBy ignorano utente null', function (): void {
        $model = new LikeableStub;

        $model->likedBy(null);
        $model->dislikedBy(null);

        Assert::assertFalse($model->isLikedBy(null));
    });

    test('isLikedBy restituisce false senza utente', function (): void {
        Assert::assertFalse((new LikeableStub)->isLikedBy(null));
    });

    test('likes restituisce la relazione caricata', function (): void {
        $model = new LikeableStub;
        $collection = new Collection;
        $model->setRelation('likesRelation', $collection);

        $likes = $model->likes();

        Assert::assertSame($collection, $likes);
    });

    test('likedBy crea il pivot e invalida la relazione', function (): void {
        /** @var UserContract&Mockery\MockInterface $user */
        $user = Mockery::mock(UserContract::class);
        $user->shouldReceive('getAttribute')->with('id')->andReturn(7);
        $user->id = '7';

        /** @var MorphMany<Like, LikeableStub>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphMany::class);
        $relation->shouldReceive('create')->once()->with(['user_id' => '7']);

        $model = new LikeableStub;
        $model->mockLikesRelation = $relation;

        $model->likedBy($user);

        Assert::assertFalse($model->relationLoaded('likesRelation'));
    });

    test('dislikedBy elimina il like esistente', function (): void {
        /** @var UserContract&Mockery\MockInterface $user */
        $user = Mockery::mock(UserContract::class);
        $user->id = '3';

        $like = Mockery::mock(Model::class);
        $like->shouldReceive('delete')->once();

        /** @var MorphMany<Like, LikeableStub>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphMany::class);
        $relation->shouldReceive('where')->with('user_id', '3')->andReturnSelf();
        $relation->shouldReceive('first')->andReturn($like);

        $model = new LikeableStub;
        $model->mockLikesRelation = $relation;

        $model->dislikedBy($user);

        Assert::assertFalse($model->relationLoaded('likesRelation'));
    });

    test('isLikedBy verifica exists sulla relazione', function (): void {
        /** @var UserContract&Mockery\MockInterface $user */
        $user = Mockery::mock(UserContract::class);
        $user->id = '9';

        /** @var MorphMany<Like, LikeableStub>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphMany::class);
        $relation->shouldReceive('where')->with('user_id', '9')->andReturnSelf();
        $relation->shouldReceive('exists')->andReturnTrue();

        $model = new LikeableStub;
        $model->mockLikesRelation = $relation;

        Assert::assertTrue($model->isLikedBy($user));
    });

    test('likesRelation del trait restituisce MorphMany su Like', function (): void {
        $model = new LikeableNativeRelationStub;
        $relation = $model->likesRelation();

        Assert::assertSame(Like::class, $relation->getRelated()::class);
    });

    test('bootHasLikes elimina i like in cascata al deleting', function (): void {
        /** @var MorphMany<Like, LikeableStub>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphMany::class);
        $relation->shouldReceive('delete')->once()->andReturn(1);

        $model = new LikeableStub;
        $model->mockLikesRelation = $relation;
        $model->setRelation('likesRelation', new Collection);

        $fire = new \ReflectionMethod(Model::class, 'fireModelEvent');
        $fire->setAccessible(true);
        $fire->invoke($model, 'deleting', false);

        Assert::assertFalse($model->relationLoaded('likesRelation'));
    });
});
