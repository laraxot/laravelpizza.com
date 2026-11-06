<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Mockery;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Models\Policies\MediaConvertPolicy;
use Modules\Media\Models\Policies\MediaPolicy;
use Modules\Media\Models\Policies\TemporaryUploadPolicy;
use Modules\Media\Models\TemporaryUpload;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-media-db');

/**
 * @param  list<string>  $permissions
 * @param  list<string>  $roles
 * @return Mockery\MockInterface&UserContract
 */
function mediaFakeUser(array $permissions = [], array $roles = []): UserContract
{
    /** @var Mockery\MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    TestCase::mockExpectation($user, 'hasPermissionTo')
        ->andReturnUsing(static function (string $permission) use ($permissions): bool {
            return in_array($permission, $permissions, true);
        });
    TestCase::mockExpectation($user, 'hasRole')
        ->andReturnUsing(static function (array|string $richiesti) use ($roles): bool {
            /** @var list<string> $normalizzati */
            $normalizzati = is_array($richiesti) ? $richiesti : [$richiesti];

            return array_intersect($normalizzati, $roles) !== [];
        });

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

describe('MediaPolicy', function (): void {
    test('super-admin bypassa before', function (): void {
        $policy = new MediaPolicy;

        Assert::assertTrue($policy->before(mediaFakeUser(roles: ['super-admin']), 'viewAny'));
    });

    test('viewAny richiede media.viewAny', function (): void {
        $policy = new MediaPolicy;

        Assert::assertTrue($policy->viewAny(mediaFakeUser(['media.viewAny'])));
        Assert::assertFalse($policy->viewAny(mediaFakeUser()));
    });

    test('view richiede media.view', function (): void {
        $policy = new MediaPolicy;
        $media = new Media;

        Assert::assertTrue($policy->view(mediaFakeUser(['media.view']), $media));
        Assert::assertFalse($policy->view(mediaFakeUser(), $media));
    });

    test('create update delete restore forceDelete', function (): void {
        $policy = new MediaPolicy;
        $media = new Media;

        Assert::assertTrue($policy->create(mediaFakeUser(['media.create'])));
        Assert::assertTrue($policy->update(mediaFakeUser(['media.update']), $media));
        Assert::assertTrue($policy->delete(mediaFakeUser(['media.delete']), $media));
        Assert::assertTrue($policy->restore(mediaFakeUser(['media.restore']), $media));
        Assert::assertTrue($policy->forceDelete(mediaFakeUser(['media.forceDelete']), $media));
    });
});

describe('MediaConvertPolicy', function (): void {
    test('abilities usano il prefisso media_convert', function (): void {
        $policy = new MediaConvertPolicy;
        $record = new MediaConvert;

        Assert::assertTrue($policy->viewAny(mediaFakeUser(['media_convert.viewAny'])));
        Assert::assertTrue($policy->view(mediaFakeUser(['media_convert.view']), $record));
        Assert::assertTrue($policy->create(mediaFakeUser(['media_convert.create'])));
        Assert::assertTrue($policy->update(mediaFakeUser(['media_convert.update']), $record));
        Assert::assertTrue($policy->delete(mediaFakeUser(['media_convert.delete']), $record));
        Assert::assertTrue($policy->restore(mediaFakeUser(['media_convert.restore']), $record));
        Assert::assertTrue($policy->forceDelete(mediaFakeUser(['media_convert.forceDelete']), $record));
    });
});

describe('TemporaryUploadPolicy', function (): void {
    test('abilities usano il prefisso temporary_upload', function (): void {
        $policy = new TemporaryUploadPolicy;
        $record = new TemporaryUpload;

        Assert::assertTrue($policy->viewAny(mediaFakeUser(['temporary_upload.viewAny'])));
        Assert::assertTrue($policy->view(mediaFakeUser(['temporary_upload.view']), $record));
        Assert::assertTrue($policy->create(mediaFakeUser(['temporary_upload.create'])));
        Assert::assertTrue($policy->update(mediaFakeUser(['temporary_upload.update']), $record));
        Assert::assertTrue($policy->delete(mediaFakeUser(['temporary_upload.delete']), $record));
        Assert::assertTrue($policy->restore(mediaFakeUser(['temporary_upload.restore']), $record));
        Assert::assertTrue($policy->forceDelete(mediaFakeUser(['temporary_upload.forceDelete']), $record));
    });
});
