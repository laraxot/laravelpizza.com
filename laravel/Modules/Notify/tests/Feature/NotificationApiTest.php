<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
beforeEach(function (): void {
    $user = UserFactory::new()->createOne(['email' => 'test@example.com']);
    $this->actingAs($user);
    Http::fake();
});

afterEach(function (): void {
    Http::assertNothingSent();
});

describe('Notification API', function (): void {
    it('POST /api/notify/send sends notification', function (): void {
        $template = NotificationTemplateFactory::new()->createOne([
            'code' => 'api-test',
            'name' => 'API Test',
            'subject' => 'Test {{name}}',
            'body_text' => 'Hello {{name}}',
            'channels' => ['database'],
            'is_active' => true,
        ]);

        Assert::assertSame('api-test', $template->code);

        $response = $this->postJson('/api/notify/send', [
            'template_code' => 'api-test',
            'data' => ['name' => 'John'],
            'channels' => ['database'],
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'type', 'message'],
            ]);
    });

    it('POST /api/notify/send validates template_code', function (): void {
        $response = $this->postJson('/api/notify/send', [
            'data' => ['name' => 'John'],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['template_code']);
    });

    it('POST /api/notify/send rejects inactive template', function (): void {
        NotificationTemplateFactory::new()->createOne([
            'code' => 'inactive-template',
            'name' => 'Inactive',
            'subject' => 'Test',
            'body_text' => 'Test',
            'channels' => ['database'],
            'is_active' => false,
        ]);

        $response = $this->postJson('/api/notify/send', [
            'template_code' => 'inactive-template',
            'data' => [],
        ]);

        $response->assertUnprocessable();
    });

    it('GET /api/notify/templates lists active templates', function (): void {
        NotificationTemplateFactory::new()->createOne(['code' => 't1', 'is_active' => true]);
        NotificationTemplateFactory::new()->createOne(['code' => 't2', 'is_active' => true]);
        NotificationTemplateFactory::new()->createOne(['code' => 't3', 'is_active' => false]);

        $response = $this->getJson('/api/notify/templates');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['code', 'name', 'channels'],
                ],
            ]);

        $payload = TestCase::assertNotifyArray($response->json());
        $data = TestCase::assertNotifyArray($payload['data'] ?? null);
        Assert::assertCount(2, $data);
    });

    it('GET /api/notify/templates/{code} shows template details', function (): void {
        $template = NotificationTemplateFactory::new()->createOne([
            'code' => 'detail-test',
            'name' => 'Detail Test',
            'subject' => 'Subject',
            'body_text' => 'Body',
            'channels' => ['database'],
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/notify/templates/detail-test');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => ['code', 'name', 'subject', 'channels', 'is_active'],
            ]);

        Assert::assertSame('detail-test', $template->code);
    });

    it('POST /api/notify/templates creates template', function (): void {
        $response = $this->postJson('/api/notify/templates', [
            'code' => 'new-template',
            'name' => 'New Template',
            'subject' => 'Hello {{name}}',
            'body_text' => 'Hi {{name}}',
            'body_html' => '<p>Hi {{name}}</p>',
            'channels' => ['database'],
            'is_active' => true,
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'success',
                'data' => ['code', 'name'],
            ]);
    });

    it('PUT /api/notify/templates/{code} updates template', function (): void {
        $template = NotificationTemplateFactory::new()->createOne([
            'code' => 'update-test',
            'name' => 'Original',
            'subject' => 'Subject',
            'body_text' => 'Body',
            'channels' => ['database'],
            'is_active' => true,
        ]);

        $response = $this->putJson('/api/notify/templates/update-test', [
            'name' => 'Updated Name',
            'subject' => 'New Subject {{var}}',
        ]);

        $response->assertOk();
        Assert::assertSame('Updated Name', XotBasePest::assertFreshModel($template, NotificationTemplate::class)->name);
    });

    it('DELETE /api/notify/templates/{code} deletes template', function (): void {
        NotificationTemplateFactory::new()->createOne(['code' => 'delete-test']);

        $response = $this->deleteJson('/api/notify/templates/delete-test');

        $response->assertNoContent();
        XotBasePest::assertTableMissing('notify', 'notification_templates', ['code' => 'delete-test']);
    });
});
