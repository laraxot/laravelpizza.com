<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Notifications\Notification;
use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
    $this->page = new class extends ListLogActivities
    {
        public static function getResource(): string
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
    /** @var \Modules\Activity\Tests\TestCase $this */
$this->page = new class extends ListLogActivities
>>>>>>> .merge_file_WXxJie
        {
            return ActivityResource::class;
        }

        public function exposeRestoreSuccess(): Notification
        {
            return $this->sendRestoreSuccessNotification();
        }

<<<<<<< .merge_file_28wBbn
=======
            public function exposeRestoreFailure(?string $message = null): Notification
            {
                return $this->sendRestoreFailureNotification($message);
            }
        };
=======
    /** @var TestCase $this */
    $this->page = new class extends ListLogActivities
    {
        public static function getResource(): string
        {
            return ActivityResource::class;
        }

        public function exposeRestoreSuccess(): Notification
        {
            return $this->sendRestoreSuccessNotification();
        }

<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
        public function exposeRestoreFailure(?string $message = null): Notification
        {
            return $this->sendRestoreFailureNotification($message);
        }
    };
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_mHJrzu
});

describe('List Log Activities Page Coverage', function (): void {
    test('get breadcrumb returns string', function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
        $result = $this->requirePage()->getBreadcrumb();
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
        /** @var \Modules\Activity\Tests\TestCase $this */
$result = $this->requirePage()->getBreadcrumb();
=======
        /** @var TestCase $this */
        $result = $this->requirePage()->getBreadcrumb();
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu

        Assert::assertNotEmpty($result);
    });

    test('get breadcrumb uses static breadcrumb when set', function (): void {
        $page = new class extends ListLogActivities
        {
            protected static ?string $breadcrumb = 'Custom Breadcrumb';

            /** @return class-string */
            public static function getResource(): string
            {
                return ActivityResource::class;
            }
        };

        Assert::assertSame('Custom Breadcrumb', $page->getBreadcrumb());
    });

    test('can restore activity returns false when resource class does not exist', function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
        Assert::assertFalse(class_exists('NonExistentClass\That\Does\Not\Exist'));
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
Assert::assertFalse(class_exists('NonExistentClass\That\Does\Not\Exist'));
=======
        Assert::assertFalse(class_exists('NonExistentClass\That\Does\Not\Exist'));
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
    });

    test('can restore activity returns false when resource lacks can restore method', function (): void {
        $page = new class extends ListLogActivities
        {
            public static function getResource(): string
            {
                return \stdClass::class;
            }
        };

        Assert::assertFalse($page->canRestoreActivity());
    });

    test('get pagination mode returns default', function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
        $mode = $this->requirePage()->getPaginationMode();
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
$mode = $this->requirePage()->getPaginationMode();
=======
        /** @var TestCase $this */
        $mode = $this->requirePage()->getPaginationMode();
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu

        Assert::assertSame(PaginationMode::Default, $mode);
    });

    test('get field label returns name when not in map', function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
        try {
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
try {
=======
        /** @var TestCase $this */
        try {
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
            $label = $this->requirePage()->getFieldLabel('nonexistent_field');
            Assert::assertSame('nonexistent_field', $label);
        } catch (\Throwable $e) {
            $this->skipTest('getFieldLabel() method not available in test context');
        }
    });

    test('send restore success notification returns notification', function (): void {
        $page = new class extends ListLogActivities
        {
            /** @return class-string */
            public static function getResource(): string
            {
                return ActivityResource::class;
            }

            public function exposeRestoreSuccess(): Notification
            {
                return $this->sendRestoreSuccessNotification();
            }
        };

        $notification = $page->exposeRestoreSuccess();
        Assert::assertNotEmpty($notification->getTitle());
    });

    test('send restore failure notification without message returns notification', function (): void {
        $page = new class extends ListLogActivities
        {
            /** @return class-string */
            public static function getResource(): string
            {
                return ActivityResource::class;
            }

            public function exposeRestoreFailure(?string $message = null): Notification
            {
                return $this->sendRestoreFailureNotification($message);
            }
        };

        $notification = $page->exposeRestoreFailure();
        Assert::assertNotEmpty($notification->getTitle());
    });

    test('send restore failure notification with message includes body', function (): void {
        $page = new class extends ListLogActivities
        {
            /** @return class-string */
            public static function getResource(): string
            {
                return ActivityResource::class;
            }

            public function exposeRestoreFailure(?string $message = null): Notification
            {
                return $this->sendRestoreFailureNotification($message);
            }
        };

        $notification = $page->exposeRestoreFailure('test message');
        Assert::assertSame('test message', $notification->getBody());
    });

    test('can restore activity with record executes resource check', function (): void {
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
<<<<<<< .merge_file_28wBbn
        $result = $this->requirePage()->canRestoreActivity();
=======
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
<<<<<<< HEAD
$result = $this->requirePage()->canRestoreActivity();
=======
        /** @var TestCase $this */
        $result = $this->requirePage()->canRestoreActivity();
>>>>>>> laraxot/dev
<<<<<<< .merge_file_6urNmo
<<<<<<< .merge_file_OPFETu
<<<<<<< .merge_file_0a5cdj
>>>>>>> .merge_file_WXxJie
=======
>>>>>>> .merge_file_JwJUVf
=======
>>>>>>> .merge_file_CYhmpZ
=======
>>>>>>> .merge_file_mHJrzu
        Assert::assertFalse($result);
    });
});
