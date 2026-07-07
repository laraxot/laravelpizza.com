<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Notifications\GenericNotification;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

// Basic unit tests focusing on business logic of recipient name resolution

describe('GenericNotification getRecipientName', function (): void {
    it('prefers getFullName() when available', function (): void {
        $notification = new GenericNotification('Title', 'Message');

        $notifiable = new class
        {
            public function getFullName(): string
            {
                return 'John Doe';
            }
        };

        $ref = new \ReflectionClass(GenericNotification::class);
        $method = $ref->getMethod('getRecipientName');
        $method->setAccessible(true);

        Assert::assertSame('John Doe', $method->invoke($notification, $notifiable));
    });

    it('uses Eloquent model full_name when present and non-empty', function (): void {
        $notification = new GenericNotification('Title', 'Message');

        $model = new class extends Model
        {
            protected $attributes = [
                'full_name' => 'Jane Roe',
            ];
        };

        $ref = new \ReflectionClass(GenericNotification::class);
        $method = $ref->getMethod('getRecipientName');
        $method->setAccessible(true);

        Assert::assertSame('Jane Roe', $method->invoke($notification, $model));
    });

    it('falls back to first_name then name then default', function (): void {
        $notification = new GenericNotification('Title', 'Message');

        // first_name present
        $model1 = new class extends Model
        {
            protected $attributes = ['first_name' => 'Alice'];
        };
        // name present
        $model2 = new class extends Model
        {
            protected $attributes = ['name' => 'Bob'];
        };
        // none present
        $model3 = new class extends Model
        {
            protected $attributes = [];
        };

        $ref = new \ReflectionClass(GenericNotification::class);
        $method = $ref->getMethod('getRecipientName');
        $method->setAccessible(true);

        Assert::assertSame('Alice', $method->invoke($notification, $model1));
        Assert::assertSame('Bob', $method->invoke($notification, $model2));
        Assert::assertSame('Utente', $method->invoke($notification, $model3));
    });
});
