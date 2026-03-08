<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;

class NotificationTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_notification_type(): void
    {
        $notificationType = NotificationType::create([
            'name' => 'Email Notification',
            'description' => 'Email notification type for sending emails',
            'template' => 'email_template_1',
        ]);

        $this->assertDatabaseHas('notification_types', [
            'id' => $notificationType->id,
            'name' => 'Email Notification',
            'description' => 'Email notification type for sending emails',
            'template' => 'email_template_1',
        ]);

        $this->assertInstanceOf(NotificationType::class, $notificationType);
    }

    /** @test */
    public function it_has_correct_fillable_fields(): void
    {
        $notificationType = new NotificationType;

        $expectedFillable = [
            'name',
            'description',
            'template',
        ];

        $this->assertEquals($expectedFillable, $notificationType->getFillable());
    }

    /** @test */
    public function it_can_update_notification_type(): void
    {
        $notificationType = NotificationType::create([
            'name' => 'Original Name',
            'description' => 'Original description',
            'template' => 'original_template',
        ]);

        $notificationType->update([
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'template' => 'updated_template',
        ]);

        // @var mixed assertDatabaseHas('notification_types', [
            'id' => $notificationType->id,
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'template' => 'updated_template',
        ]);

        // @var mixed assertEquals('Updated Name', $notificationType->fresh(;
        // @var mixed assertEquals('Updated description', $notificationType->fresh(;
        // @var mixed assertEquals('updated_template', $notificationType->fresh(;
    }

    /** @test */
    public function it_can_find_by_name(): void
    {
        $notificationType = NotificationType::create([
            'name' => 'SMS Notification',
            'description' => 'SMS notification type',
            'template' => 'sms_template',
        ]);

        $found = NotificationType::where('name', 'SMS Notification')->first();

        // @var mixed assertNotNull($found;
        // @var mixed assertEquals($notificationType->id, $found->id;
        // @var mixed assertEquals('SMS Notification', $found->name;
        // @var mixed assertEquals('SMS notification type', $found->description;
        // @var mixed assertEquals('sms_template', $found->template;
    }

    /** @test */
    public function it_can_find_by_template(): void
    {
        NotificationType::create([
            'name' => 'Email Type 1',
            'description' => 'First email template',
            'template' => 'email_template_1',
        ]);

        NotificationType::create([
            'name' => 'Email Type 2',
            'description' => 'Second email template',
            'template' => 'email_template_2',
        ]);

        $template1Types = NotificationType::where('template', 'email_template_1')->get();
        $template2Types = NotificationType::where('template', 'email_template_2')->get();

        // @var mixed assertCount(1, $template1Types;
        // @var mixed assertCount(1, $template2Types;
        // @var mixed assertEquals('email_template_1', $template1Types[0]->template;
        // @var mixed assertEquals('email_template_2', $template2Types[0]->template;
    }

    /** @test */
    public function it_can_find_by_description_pattern(): void
    {
        NotificationType::create([
            'name' => 'Email Type',
            'description' => 'Email notification type for users',
            'template' => 'email_template',
        ]);

        NotificationType::create([
            'name' => 'SMS Type',
            'description' => 'SMS notification type for users',
            'template' => 'sms_template',
        ]);

        NotificationType::create([
            'name' => 'Push Type',
            'description' => 'Push notification type for mobile',
            'template' => 'push_template',
        ]);

        $userTypes = NotificationType::where('description', 'like', '%for users%')->get();
        $mobileTypes = NotificationType::where('description', 'like', '%mobile%')->get();

        // @var mixed assertCount(2, $userTypes;
        // @var mixed assertCount(1, $mobileTypes;
        // @var mixed assertStringContainsString('for users', $userTypes[0]->description;
        // @var mixed assertStringContainsString('for users', $userTypes[1]->description;
        // @var mixed assertStringContainsString('mobile', $mobileTypes[0]->description;
    }

    /** @test */
    public function it_can_handle_null_values(): void
    {
        $notificationType = NotificationType::create([
            'name' => 'No Description Type',
            'description' => null,
            'template' => null,
        ]);

        // @var mixed assertNull($notificationType->description;
        // @var mixed assertNull($notificationType->template;
        // @var mixed assertDatabaseHas('notification_types', [
            'id' => $notificationType->id,
            'description' => null,
            'template' => null,
        ]);
    }

    /** @test */
    public function it_can_create_multiple_types(): void
    {
        $types = [
            ['name' => 'Email', 'description' => 'Email notifications', 'template' => 'email'],
            ['name' => 'SMS', 'description' => 'SMS notifications', 'template' => 'sms'],
            ['name' => 'Push', 'description' => 'Push notifications', 'template' => 'push'],
            ['name' => 'Database', 'description' => 'Database notifications', 'template' => 'database'],
            ['name' => 'Slack', 'description' => 'Slack notifications', 'template' => 'slack'],
        ];

        foreach ($types as $typeData) {
            NotificationType::create($typeData);
        }

        // @var mixed assertDatabaseCount('notification_types', 5;

        $emailType = NotificationType::where('name', 'Email')->first();
        $smsType = NotificationType::where('name', 'SMS')->first();
        $pushType = NotificationType::where('name', 'Push')->first();

        // @var mixed assertEquals('Email notifications', $emailType->description;
        // @var mixed assertEquals('SMS notifications', $smsType->description;
        // @var mixed assertEquals('Push notifications', $pushType->description;
        // @var mixed assertEquals('email', $emailType->template;
        // @var mixed assertEquals('sms', $smsType->template;
        // @var mixed assertEquals('push', $pushType->template;
    }

    /** @test */
    public function it_can_find_by_multiple_criteria(): void
    {
        NotificationType::create([
            'name' => 'High Priority Email',
            'description' => 'High priority email notifications',
            'template' => 'high_priority_email',
        ]);

        NotificationType::create([
            'name' => 'Low Priority Email',
            'description' => 'Low priority email notifications',
            'template' => 'low_priority_email',
        ]);

        NotificationType::create([
            'name' => 'High Priority SMS',
            'description' => 'High priority SMS notifications',
            'template' => 'high_priority_sms',
        ]);

        $highPriorityEmailTypes = NotificationType::where('name', 'like', '%High Priority%')
            ->where('description', 'like', '%email%')
            ->get();

        // @var mixed assertCount(1, $highPriorityEmailTypes;
        // @var mixed assertEquals('High Priority Email', $highPriorityEmailTypes[0]->name;
        // @var mixed assertEquals('High priority email notifications', $highPriorityEmailTypes[0]->description;
        // @var mixed assertEquals('high_priority_email', $highPriorityEmailTypes[0]->template;
    }
}
