<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Notify\Models\Contact;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Tests\Fixtures\NotifyBaseMorphPivotProxy;
use Modules\Notify\Tests\Fixtures\NotifyBasePivotProxy;
use Modules\Notify\Tests\Fixtures\NotifyNotificationTemplateProxy;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

function makeNotifyBaseMorphPivotProxy(): NotifyBaseMorphPivotProxy
{
    return new NotifyBaseMorphPivotProxy;
}

function makeNotifyBasePivotProxy(): NotifyBasePivotProxy
{
    return new NotifyBasePivotProxy;
}

function makeNotifyNotificationTemplateProxy(): NotifyNotificationTemplateProxy
{
    return new NotifyNotificationTemplateProxy;
}

test('base morph pivot and base pivot use notify connection and default casts', function () {
    $morphPivot = makeNotifyBaseMorphPivotProxy();
    $pivot = makeNotifyBasePivotProxy();

    Assert::assertSame('notify', $morphPivot->getConnectionName());
    Assert::assertSame('notify', $pivot->getConnectionName());
    Assert::assertArrayHasKey('created_at', $morphPivot->exposedCasts());
    Assert::assertArrayHasKey('updated_at', $pivot->exposedCasts());
});

test('contact model has expected fillable and casts', function () {
    $contact = new Contact;

    Assert::assertSame('notify', $contact->getConnectionName());
    Assert::assertContains('model_id', $contact->getFillable());
    Assert::assertContains('contact_type', $contact->getFillable());
    Assert::assertArrayHasKey('model_id', $contact->getCasts());
    Assert::assertArrayHasKey('user_id', $contact->getCasts());
});

test('mail template has slug options and expected casts', function () {
    $mailTemplate = new MailTemplate;

    Assert::assertSame('notify', $mailTemplate->getConnectionName());
    Assert::assertContains('slug', $mailTemplate->getFillable());
    Assert::assertContains('html_layout_path', $mailTemplate->getFillable());
    Assert::assertArrayHasKey('created_at', $mailTemplate->getCasts());
    Assert::assertSame('slug', $mailTemplate->getSlugOptions()->generateSlugFrom);
});

test('notification model has array and datetime casts', function () {
    $notification = new Notification;

    Assert::assertContains('message', $notification->getFillable());
    Assert::assertContains('channels', $notification->getFillable());
    Assert::assertArrayHasKey('data', $notification->getCasts());
    Assert::assertArrayHasKey('read_at', $notification->getCasts());
});

test('notification template compile and helper methods return expected structures', function () {
    $template = makeNotifyNotificationTemplateProxy();

    $template->subject = 'Hello {{ $name }}';
    $template->body_html = '<p>Body {{ $name }}</p>';
    $template->body_text = 'Body {{ $name }}';
    $template->preview_data = ['name' => 'Mario'];
    $template->channels = ['mail', 'sms'];

    $compiled = $template->compile(['name' => 'Luigi']);
    $preview = $template->preview();

    Assert::assertContains('grapesjs_data', $template->getFillable());
    Assert::assertArrayHasKey('channels', $template->exposedCasts());
    Assert::assertArrayHasKey('subject', $compiled);
    Assert::assertArrayHasKey('body_html', $compiled);
    Assert::assertArrayHasKey('body_text', $compiled);
    Assert::assertArrayHasKey('subject', $preview);
    Assert::assertArrayHasKey('body_html', $preview);
    Assert::assertArrayHasKey('body_text', $preview);
    Assert::assertTrue($template->shouldSend(['foo' => 'bar']));

    $template->conditions = ['foo' => 'bar'];
    Assert::assertTrue($template->shouldSend(['foo' => 'bar']));
    Assert::assertFalse($template->shouldSend(['foo' => 'baz']));
});

test('notify theme exposes logo accessor and morph relation', function () {
    $theme = new NotifyTheme;
    $theme->logo_width = 300;
    $theme->logo_height = 120;

    $logo = $theme->getLogoAttribute(null);
    $relation = $theme->linkable();

    Assert::assertSame('notify', $theme->getConnectionName());
    Assert::assertContains('logo_src', $theme->getFillable());
    Assert::assertContains('view_params', $theme->getFillable());
    Assert::assertArrayHasKey('view_params', $theme->getCasts());
    Assert::assertSame(300, $logo['width']);
    Assert::assertSame(120, $logo['height']);
    Assert::assertInstanceOf(MorphTo::class, $relation);
});
