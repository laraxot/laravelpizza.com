<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
<<<<<<< .merge_file_EjJwpO
use Illuminate\Support\Collection;
=======
>>>>>>> .merge_file_jXWqwV
use LogicException;
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\Fixtures\ActivitySubjectHarness;
use Modules\Activity\Tests\Fixtures\ActivitySubjectNoActivitiesMethodHarness;
use Modules\Activity\Tests\Fixtures\ActivitySubjectWithoutRelationHarness;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesHtmlTitleHarness;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesPageHarness;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesRestorableResource;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesStdClassResourceHarness;
use Modules\Activity\Tests\Fixtures\RestoreActivityActionFails;
use Modules\Activity\Tests\Fixtures\RestoreActivityActionNoOp;
<<<<<<< .merge_file_EjJwpO
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpKernel\Exception\HttpException;

function activitySubjectForPage(string $id = 'page-subj'): ActivitySubjectHarness
{
    $subject = new ActivitySubjectHarness();
=======
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpKernel\Exception\HttpException;

uses(TestCase::class);

function activitySubjectForPage(string $id = 'page-subj'): ActivitySubjectHarness
{
    $subject = new ActivitySubjectHarness;
>>>>>>> .merge_file_jXWqwV
    $subject->forceFill(['id' => $id, 'name' => 'S']);
    $subject->exists = true;

    return $subject;
}

test('ListLogActivities getTitle e breadcrumb con Htmlable', function (): void {
<<<<<<< .merge_file_EjJwpO
    $page = new ListLogActivitiesPageHarness();
=======
    $page = new ListLogActivitiesPageHarness;
>>>>>>> .merge_file_jXWqwV
    $page->setRecordForTest(activitySubjectForPage());

    Assert::assertNotEmpty($page->getBreadcrumb());
    Assert::assertStringContainsString('Record Titolo', $page->getTitle());

<<<<<<< .merge_file_EjJwpO
    $htmlPage = new ListLogActivitiesHtmlTitleHarness();
=======
    $htmlPage = new ListLogActivitiesHtmlTitleHarness;
>>>>>>> .merge_file_jXWqwV
    $htmlPage->setRecordForTest(activitySubjectForPage('html-subj'));
    Assert::assertStringContainsString('HTML', $htmlPage->getTitle());
});

test('ListLogActivities getActivities paginate e errori record', function (): void {
    $subject = activitySubjectForPage('act-subj');
    Activity::create([
        'log_name' => 'default',
        'description' => 'd',
        'subject_type' => ActivitySubjectHarness::class,
        'subject_id' => $subject->id,
        'event' => 'touch',
        'properties' => ['old' => ['name' => 'a']],
    ]);

<<<<<<< .merge_file_EjJwpO
    $page = new ListLogActivitiesPageHarness();
=======
    $page = new ListLogActivitiesPageHarness;
>>>>>>> .merge_file_jXWqwV
    $page->setRecordForTest($subject);

    $paginator = $page->getActivities();
    Assert::assertInstanceOf(LengthAwarePaginator::class, $paginator);
    Assert::assertGreaterThanOrEqual(1, $paginator->total());

<<<<<<< .merge_file_EjJwpO
    $pageNoRecord = new ListLogActivitiesPageHarness();
    expect(fn (): mixed => $pageNoRecord->getActivities())
        ->toThrow(\Error::class);

    $pageNoMethod = new ListLogActivitiesPageHarness();
    $pageNoMethod->setRecordForTest(new ActivitySubjectNoActivitiesMethodHarness());
    expect(fn (): mixed => $pageNoMethod->getActivities())
        ->toThrow(LogicException::class);

    $pageBadRel = new ListLogActivitiesPageHarness();
    $pageBadRel->setRecordForTest(new ActivitySubjectWithoutRelationHarness());
    expect(fn (): mixed => $pageBadRel->getActivities())
=======
    $pageNoRecord = new ListLogActivitiesPageHarness;
    expect(fn (): \Illuminate\Contracts\Pagination\LengthAwarePaginator => $pageNoRecord->getActivities())
        ->toThrow(\Error::class);

    $pageNoMethod = new ListLogActivitiesPageHarness;
    $pageNoMethod->setRecordForTest(new ActivitySubjectNoActivitiesMethodHarness);
    expect(fn (): \Illuminate\Contracts\Pagination\LengthAwarePaginator => $pageNoMethod->getActivities())
        ->toThrow(LogicException::class);

    $pageBadRel = new ListLogActivitiesPageHarness;
    $pageBadRel->setRecordForTest(new ActivitySubjectWithoutRelationHarness);
    expect(fn (): \Illuminate\Contracts\Pagination\LengthAwarePaginator => $pageBadRel->getActivities())
>>>>>>> .merge_file_jXWqwV
        ->toThrow(\InvalidArgumentException::class);
});

test('ListLogActivities canRestore e restoreActivity percorsi', function (): void {
    $subject = activitySubjectForPage('restore-subj');
    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'restore me',
        'subject_type' => ActivitySubjectHarness::class,
        'subject_id' => $subject->id,
        'event' => 'updated',
        'properties' => ['old' => ['name' => 'prima']],
    ]);

<<<<<<< .merge_file_EjJwpO
    $page = new ListLogActivitiesPageHarness();
=======
    $page = new ListLogActivitiesPageHarness;
>>>>>>> .merge_file_jXWqwV
    $page->setRecordForTest($subject);
    ListLogActivitiesRestorableResource::$restoreAllowed = true;
    Assert::assertTrue($page->canRestoreActivity());

<<<<<<< .merge_file_EjJwpO
    app()->instance(RestoreActivityAction::class, new RestoreActivityActionNoOp());
=======
    app()->instance(RestoreActivityAction::class, new RestoreActivityActionNoOp);
>>>>>>> .merge_file_jXWqwV
    $page->restoreActivity((int) $activity->id);

    ListLogActivitiesRestorableResource::$restoreAllowed = false;
    Assert::assertFalse($page->canRestoreActivity());

    try {
        $page->restoreActivity((int) $activity->id);
        Assert::fail('Expected 403 abort');
    } catch (HttpException $e) {
        Assert::assertSame(403, $e->getStatusCode());
    }

    ListLogActivitiesRestorableResource::$restoreAllowed = true;
<<<<<<< .merge_file_EjJwpO
    app()->instance(RestoreActivityAction::class, new RestoreActivityActionFails());
=======
    app()->instance(RestoreActivityAction::class, new RestoreActivityActionFails);
>>>>>>> .merge_file_jXWqwV
    $page->restoreActivity((int) $activity->id);
});

test('ListLogActivities resolveActivity getOldProperties e field label map', function (): void {
    $subject = activitySubjectForPage('resolve-subj');
    $activity = Activity::create([
        'log_name' => 'default',
        'description' => 'r',
        'subject_type' => ActivitySubjectHarness::class,
        'subject_id' => $subject->id,
        'event' => 'updated',
        'properties' => ['old' => ['name' => 'old']],
    ]);

<<<<<<< .merge_file_EjJwpO
    $page = new ListLogActivitiesPageHarness();
=======
    $page = new ListLogActivitiesPageHarness;
>>>>>>> .merge_file_jXWqwV
    $page->setRecordForTest($subject);

    $resolved = $page->exposeResolveActivity((int) $activity->id);
    Assert::assertSame($activity->id, $resolved->id);
    Assert::assertSame(['name' => 'old'], $page->exposeGetOldProperties($resolved));

<<<<<<< .merge_file_EjJwpO
    $badProps = new Activity();
    $badProps->forceFill(['properties' => ['old' => 'not-array']]);
    expect(fn (): mixed => $page->exposeGetOldProperties($badProps))
        ->toThrow(Exception::class);

    expect(fn (): mixed => $page->exposeResolveActivity(999999))
        ->toThrow(Exception::class, 'Activity not found');

    $pageNoRec = new ListLogActivitiesPageHarness();
    expect(fn (): mixed => $pageNoRec->exposeResolveActivity(1))
        ->toThrow(\Error::class);

    $pageNoMethod = new ListLogActivitiesPageHarness();
    $pageNoMethod->setRecordForTest(new ActivitySubjectNoActivitiesMethodHarness());
    expect(fn (): mixed => $pageNoMethod->exposeResolveActivity(1))
        ->toThrow(LogicException::class);

    $pageBadRel = new ListLogActivitiesPageHarness();
    $pageBadRel->setRecordForTest(new ActivitySubjectWithoutRelationHarness());
    expect(fn (): mixed => $pageBadRel->exposeResolveActivity(1))
        ->toThrow(Exception::class, 'Invalid activities relation');

    Assert::assertSame('campo', $page->getFieldLabel('campo'));
    $map = $page->exposeCreateFieldLabelMap();
    Assert::assertInstanceOf(Collection::class, $map);
});

test('ListLogActivities canRestore senza record o resource invalida', function (): void {
    $page = new ListLogActivitiesPageHarness();
    Assert::assertFalse($page->canRestoreActivity());

    $stdPage = new ListLogActivitiesStdClassResourceHarness();
=======
    $badProps = new Activity;
    $badProps->forceFill(['properties' => ['old' => 'not-array']]);
    expect(fn (): array => $page->exposeGetOldProperties($badProps))
        ->toThrow(Exception::class);

    expect(fn (): Activity => $page->exposeResolveActivity(999999))
        ->toThrow(Exception::class, 'Activity not found');

    $pageNoRec = new ListLogActivitiesPageHarness;
    expect(fn (): Activity => $pageNoRec->exposeResolveActivity(1))
        ->toThrow(\Error::class);

    $pageNoMethod = new ListLogActivitiesPageHarness;
    $pageNoMethod->setRecordForTest(new ActivitySubjectNoActivitiesMethodHarness);
    expect(fn (): Activity => $pageNoMethod->exposeResolveActivity(1))
        ->toThrow(LogicException::class);

    $pageBadRel = new ListLogActivitiesPageHarness;
    $pageBadRel->setRecordForTest(new ActivitySubjectWithoutRelationHarness);
    expect(fn (): Activity => $pageBadRel->exposeResolveActivity(1))
        ->toThrow(Exception::class, 'Invalid activities relation');

    Assert::assertSame('campo', $page->getFieldLabel('campo'));
    Assert::assertTrue($page->exposeCreateFieldLabelMap()->isNotEmpty());
});

test('ListLogActivities canRestore senza record o resource invalida', function (): void {
    $page = new ListLogActivitiesPageHarness;
    Assert::assertFalse($page->canRestoreActivity());

    $stdPage = new ListLogActivitiesStdClassResourceHarness;
>>>>>>> .merge_file_jXWqwV
    $stdPage->setRecordForTest(activitySubjectForPage('std'));
    Assert::assertFalse($stdPage->canRestoreActivity());
});
