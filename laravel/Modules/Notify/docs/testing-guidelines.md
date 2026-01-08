# Notify Module - Testing Guidelines

## Testing Framework Configuration

All tests in the Notify module MUST use the Pest testing framework with `.env.testing` configuration.

```php
// Test environment setup
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE={{project_name}}_data_test
QUEUE_CONNECTION=sync
MAIL_MAILER=log
CACHE_DRIVER=array
SESSION_DRIVER=array
```

## Core Testing Categories

### 1. Notification Management Tests

#### Notification Creation and Delivery
```php
describe('Notification Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->notificationType = NotificationType::factory()->create([
            'name' => 'appointment_reminder',
            'priority' => 'high',
            'channels' => ['email', 'sms'],
        ]);
    });

    it('can create and send notification with proper template', function () {
        $template = NotificationTemplate::factory()->create([
            'notification_type_id' => $this->notificationType->id,
            'subject' => 'Appointment Reminder',
            'content' => 'Your appointment is scheduled for {date}',
        ]);

        $notification = Notification::create([
            'user_id' => $this->user->id,
            'notification_type_id' => $this->notificationType->id,
            'template_id' => $template->id,
            'data' => json_encode(['date' => '2024-01-15 10:00']),
            'scheduled_at' => now()->addHour(),
        ]);

        expect($notification)->toBeInstanceOf(Notification::class)
            ->and($notification->status)->toBe('pending')
            ->and($notification->user_id)->toBe($this->user->id);
    });

    it('can track notification delivery status', function () {
        $notification = Notification::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $notification->markAsDelivered('email');

        expect($notification->fresh()->status)->toBe('delivered')
            ->and($notification->delivered_at)->not->toBeNull()
            ->and($notification->delivery_channel)->toBe('email');
    });

    it('can handle notification delivery failures with retry logic', function () {
        $notification = Notification::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
            'retry_count' => 0,
        ]);

        $notification->markAsFailed('SMTP connection failed');

        expect($notification->fresh()->status)->toBe('failed')
            ->and($notification->retry_count)->toBe(1)
            ->and($notification->last_error)->toBe('SMTP connection failed');
    });
});
```

### 2. Email Template System Tests

#### Template Management and Versioning
```php
describe('Email Template System', function () {
    beforeEach(function () {
        $this->theme = Theme::factory()->create([
            'name' => 'healthcare_theme',
            'is_active' => true,
        ]);
    });

    it('can create email template with versioning', function () {
        $template = MailTemplate::create([
            'name' => 'appointment_confirmation',
            'subject' => 'Appointment Confirmed',
            'content' => '<h1>Your appointment is confirmed</h1>',
            'theme_id' => $this->theme->id,
            'version' => '1.0',
        ]);

        expect($template)->toBeInstanceOf(MailTemplate::class)
            ->and($template->version)->toBe('1.0')
            ->and($template->theme_id)->toBe($this->theme->id);

        $this->assertDatabaseHas('mail_templates', [
            'id' => $template->id,
            'name' => 'appointment_confirmation',
            'version' => '1.0',
        ]);
    });

    it('can create new template version while preserving history', function () {
        $originalTemplate = MailTemplate::factory()->create([
            'name' => 'welcome_email',
            'version' => '1.0',
            'content' => 'Welcome to our healthcare system',
        ]);

        $newVersion = MailTemplateVersion::create([
            'mail_template_id' => $originalTemplate->id,
            'version' => '1.1',
            'content' => 'Welcome to our improved healthcare system',
            'changes_summary' => 'Updated welcome message',
            'created_by' => User::factory()->create()->id,
        ]);

        expect($newVersion)->toBeInstanceOf(MailTemplateVersion::class)
            ->and($newVersion->version)->toBe('1.1')
            ->and($newVersion->mail_template_id)->toBe($originalTemplate->id);

        expect(MailTemplateVersion::where('mail_template_id', $originalTemplate->id)->count())->toBe(1);
    });

    it('can render template with dynamic content', function () {
        $template = MailTemplate::factory()->create([
            'content' => 'Hello {patient_name}, your appointment with Dr. {doctor_name} is on {date}',
        ]);

        $data = [
            'patient_name' => 'John Doe',
            'doctor_name' => 'Smith',
            'date' => '2024-01-15',
        ];

        $rendered = $template->render($data);

        expect($rendered)->toBe('Hello John Doe, your appointment with Dr. Smith is on 2024-01-15');
    });
});
```

### 3. Contact Management Tests

#### Contact Preferences and Validation
```php
describe('Contact Management', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    it('can manage contact preferences', function () {
        $contact = Contact::create([
            'user_id' => $this->user->id,
            'email' => 'patient@example.com',
            'phone' => '+1234567890',
            'preferences' => json_encode([
                'email_notifications' => true,
                'sms_notifications' => false,
                'marketing_emails' => false,
                'appointment_reminders' => true,
            ]),
        ]);

        expect($contact)->toBeInstanceOf(Contact::class)
            ->and($contact->user_id)->toBe($this->user->id)
            ->and($contact->email)->toBe('patient@example.com');

        $preferences = json_decode($contact->preferences, true);
        expect($preferences['email_notifications'])->toBeTrue()
            ->and($preferences['sms_notifications'])->toBeFalse()
            ->and($preferences['marketing_emails'])->toBeFalse();
    });

    it('can validate contact information', function () {
        $contact = Contact::factory()->make([
            'email' => 'invalid-email',
            'phone' => '123', // Invalid phone
        ]);

        $validator = Validator::make($contact->toArray(), [
            'email' => 'required|email',
            'phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
        expect($validator->errors()->has('phone'))->toBeTrue();
    });

    it('can handle opt-out requests while preserving critical notifications', function () {
        $contact = Contact::factory()->create([
            'user_id' => $this->user->id,
            'preferences' => json_encode([
                'marketing_emails' => true,
                'appointment_reminders' => true,
                'emergency_notifications' => true,
            ]),
        ]);

        $contact->optOut('marketing');

        $preferences = json_decode($contact->fresh()->preferences, true);
        expect($preferences['marketing_emails'])->toBeFalse()
            ->and($preferences['appointment_reminders'])->toBeTrue()
            ->and($preferences['emergency_notifications'])->toBeTrue();
    });
});
```

### 4. Notification Type and Category Tests

#### Type Management and Priority Handling
```php
describe('Notification Types', function () {
    it('can create notification types with proper categorization', function () {
        $medicalType = NotificationType::create([
            'name' => 'test_results',
            'category' => 'medical',
            'priority' => 'high',
            'description' => 'Laboratory test results notification',
            'channels' => json_encode(['email', 'sms', 'push']),
            'is_critical' => true,
        ]);

        expect($medicalType)->toBeInstanceOf(NotificationType::class)
            ->and($medicalType->category)->toBe('medical')
            ->and($medicalType->priority)->toBe('high')
            ->and($medicalType->is_critical)->toBeTrue();

        $channels = json_decode($medicalType->channels, true);
        expect($channels)->toContain('email', 'sms', 'push');
    });

    it('can enforce priority-based delivery rules', function () {
        $criticalType = NotificationType::factory()->create([
            'priority' => 'critical',
            'is_critical' => true,
        ]);

        $normalType = NotificationType::factory()->create([
            'priority' => 'normal',
            'is_critical' => false,
        ]);

        expect($criticalType->canBypassUserPreferences())->toBeTrue();
        expect($normalType->canBypassUserPreferences())->toBeFalse();
    });

    it('can validate notification type configuration', function () {
        $type = NotificationType::factory()->make([
            'channels' => json_encode(['invalid_channel']),
        ]);

        $validChannels = ['email', 'sms', 'push', 'in_app'];
        $typeChannels = json_decode($type->channels, true);
        
        $hasValidChannels = collect($typeChannels)->every(fn($channel) => 
            in_array($channel, $validChannels)
        );

        expect($hasValidChannels)->toBeFalse();
    });
});
```

### 5. Theme Management Tests

#### Theme Application and Customization
```php
describe('Theme Management', function () {
    it('can create and apply themes to templates', function () {
        $theme = Theme::create([
            'name' => 'modern_healthcare',
            'description' => 'Modern healthcare communication theme',
            'css_styles' => 'body { font-family: Arial; color: #333; }',
            'html_structure' => '<div class="container">{content}</div>',
            'is_active' => true,
        ]);

        $template = MailTemplate::factory()->create([
            'theme_id' => $theme->id,
            'content' => 'Welcome to our clinic',
        ]);

        expect($theme)->toBeInstanceOf(Theme::class)
            ->and($theme->is_active)->toBeTrue()
            ->and($template->theme_id)->toBe($theme->id);

        $renderedWithTheme = $template->renderWithTheme();
        expect($renderedWithTheme)->toContain('<div class="container">');
        expect($renderedWithTheme)->toContain('Welcome to our clinic');
    });

    it('can manage theme versioning and updates', function () {
        $theme = Theme::factory()->create([
            'version' => '1.0',
            'css_styles' => 'body { background: white; }',
        ]);

        $theme->update([
            'version' => '1.1',
            'css_styles' => 'body { background: #f5f5f5; }',
        ]);

        expect($theme->fresh()->version)->toBe('1.1')
            ->and($theme->fresh()->css_styles)->toContain('#f5f5f5');
    });
});
```

### 6. Integration Tests

#### Multi-Channel Delivery and External Service Integration
```php
describe('Integration Tests', function () {
    it('can deliver notifications across multiple channels', function () {
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'user_id' => $user->id,
            'preferences' => json_encode([
                'email_notifications' => true,
                'sms_notifications' => true,
            ]),
        ]);

        $notification = Notification::factory()->create([
            'user_id' => $user->id,
            'channels' => json_encode(['email', 'sms']),
        ]);

        $notification->deliver();

        Queue::assertPushed(SendEmailNotification::class);
        Queue::assertPushed(SendSmsNotification::class);
    });

    it('can handle external service failures gracefully', function () {
        $notification = Notification::factory()->create([
            'status' => 'pending',
            'retry_count' => 0,
        ]);

        // Simulate external service failure
        $this->mock(EmailService::class, function ($mock) {
            $mock->shouldReceive('send')->andThrow(new ServiceException('SMTP server unavailable'));
        });

        $result = $notification->attemptDelivery('email');

        expect($result)->toBeFalse();
        expect($notification->fresh()->status)->toBe('failed');
        expect($notification->fresh()->retry_count)->toBe(1);
    });
});
```

### 7. Performance Tests

#### Load Testing and Optimization
```php
describe('Performance Tests', function () {
    it('can handle bulk notification processing efficiently', function () {
        $users = User::factory()->count(1000)->create();
        $template = MailTemplate::factory()->create();

        $startTime = microtime(true);

        $notifications = $users->map(function ($user) use ($template) {
            return Notification::create([
                'user_id' => $user->id,
                'template_id' => $template->id,
                'status' => 'pending',
            ]);
        });

        $processingTime = microtime(true) - $startTime;

        expect($notifications)->toHaveCount(1000);
        expect($processingTime)->toBeLessThan(5.0); // Should complete within 5 seconds
    });

    it('can optimize template rendering performance', function () {
        $template = MailTemplate::factory()->create([
            'content' => str_repeat('Content with {variable} ', 1000),
        ]);

        $data = ['variable' => 'test value'];

        $startTime = microtime(true);
        $rendered = $template->render($data);
        $renderTime = microtime(true) - $startTime;

        expect($rendered)->toContain('test value');
        expect($renderTime)->toBeLessThan(0.1); // Should render within 100ms
    });
});
```

### 8. Security and Compliance Tests

#### Data Protection and Privacy Compliance
```php
describe('Security and Compliance', function () {
    it('can encrypt sensitive notification content', function () {
        $sensitiveData = [
            'patient_ssn' => '123-45-6789',
            'medical_record_number' => 'MRN123456',
        ];

        $notification = Notification::create([
            'user_id' => User::factory()->create()->id,
            'data' => json_encode($sensitiveData),
            'is_sensitive' => true,
        ]);

        $storedData = $notification->getDecryptedData();
        
        expect($storedData['patient_ssn'])->toBe('123-45-6789');
        expect($notification->data)->not->toContain('123-45-6789'); // Should be encrypted in storage
    });

    it('can maintain audit trails for all notification activities', function () {
        $notification = Notification::factory()->create();

        $notification->markAsDelivered('email');
        $notification->markAsRead();

        $auditLogs = $notification->auditLogs;

        expect($auditLogs)->toHaveCount(2);
        expect($auditLogs->first()->action)->toBe('delivered');
        expect($auditLogs->last()->action)->toBe('read');
    });

    it('can validate HIPAA compliance for medical notifications', function () {
        $medicalNotification = Notification::factory()->create([
            'notification_type_id' => NotificationType::factory()->create([
                'category' => 'medical',
                'is_hipaa_sensitive' => true,
            ])->id,
        ]);

        expect($medicalNotification->requiresHipaaCompliance())->toBeTrue();
        expect($medicalNotification->hasRequiredEncryption())->toBeTrue();
        expect($medicalNotification->hasAuditTrail())->toBeTrue();
    });
});
```

## Test Environment Setup

### Database Configuration
```php
// TestCase.php setup
protected function setUp(): void
{
    parent::setUp();
    
    // Use testing database
    config(['database.default' => 'sqlite']);
    config(['database.connections.sqlite.database' => ':memory:']);
    
    // Configure notification testing
    config(['mail.default' => 'log']);
    config(['queue.default' => 'sync']);
    
    // Set up test notification channels
    config(['notify.channels' => [
        'email' => TestEmailChannel::class,
        'sms' => TestSmsChannel::class,
    ]]);
}
```

### Mock External Services
```php
// Mock email service for testing
$this->mock(EmailServiceInterface::class, function ($mock) {
    $mock->shouldReceive('send')
         ->andReturn(true);
    
    $mock->shouldReceive('getDeliveryStatus')
         ->andReturn('delivered');
});

// Mock SMS service for testing
$this->mock(SmsServiceInterface::class, function ($mock) {
    $mock->shouldReceive('send')
         ->andReturn(['status' => 'sent', 'message_id' => 'test123']);
});
```

## Testing Best Practices

### 1. Test Organization
- Group related tests using `describe()` blocks
- Use descriptive test names that explain business scenarios
- Implement proper setup and teardown in `beforeEach()` and `afterEach()`

### 2. Data Management
- Use factories for consistent test data creation
- Clean up test data after each test
- Use transactions for database tests when possible

### 3. Assertion Patterns
- Use Pest's fluent assertion syntax with `expect()`
- Test both positive and negative scenarios
- Verify database state changes with appropriate assertions

### 4. Performance Considerations
- Mock external services to avoid network calls
- Use in-memory database for faster test execution
- Implement performance benchmarks for critical operations

### 5. Security Testing
- Test encryption and decryption of sensitive data
- Verify access controls and permissions
- Test audit logging and compliance requirements

This testing framework ensures comprehensive coverage of the Notify module's business logic while maintaining fast, reliable, and maintainable tests using the Pest framework with `.env.testing` configuration.
