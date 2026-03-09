<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Notify\Models\BaseMorphPivot;
use Modules\Notify\Models\BasePivot;
use Modules\Notify\Models\Contact;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

function makeNotifyBaseMorphPivotProxy(): BaseMorphPivot
{
    return new class extends BaseMorphPivot
    {
        protected $table = 'notify_base_morph_pivot_proxy';

        public function exposedCasts(): array
        {
            return $this->casts();
        }
    };
}

function makeNotifyBasePivotProxy(): BasePivot
{
    return new class extends BasePivot
    {
        protected $table = 'notify_base_pivot_proxy';

        public function exposedCasts(): array
        {
            return $this->casts();
        }
    };
}

function makeNotifyNotificationTemplateProxy(): NotificationTemplate
{
    return new class extends NotificationTemplate
    {
        public function exposedCompileString(?string $template, array $data): ?string
        {
            return $this->compileString($template, $data);
        }

        public function exposedCasts(): array
        {
            return $this->casts();
        }
    };
}

test('base morph pivot and base pivot use notify connection and default casts', function () {
    $morphPivot = makeNotifyBaseMorphPivotProxy();
    $pivot = makeNotifyBasePivotProxy();

    expect($morphPivot->getConnectionName())->toBe('notify')
        ->and($pivot->getConnectionName())->toBe('notify')
        ->and($morphPivot->exposedCasts())->toHaveKey('created_at')
        ->and($pivot->exposedCasts())->toHaveKey('updated_at');
});

test('contact model has expected fillable and casts', function () {
    $contact = new Contact();

    expect($contact->getConnectionName())->toBe('notify')
        ->and($contact->getFillable())->toContain('model_id')
        ->and($contact->getFillable())->toContain('contact_type')
        ->and($contact->getCasts())->toHaveKey('model_id')
        ->and($contact->getCasts())->toHaveKey('user_id');
});

test('mail template has slug options and expected casts', function () {
    $mailTemplate = new MailTemplate();

    expect($mailTemplate->getConnectionName())->toBe('notify')
        ->and($mailTemplate->getFillable())->toContain('slug')
        ->and($mailTemplate->getFillable())->toContain('html_layout_path')
        ->and($mailTemplate->getCasts())->toHaveKey('created_at');

    $slugOptions = $mailTemplate->getSlugOptions();
    expect($slugOptions)->not->toBeNull();
});

test('notification model has array and datetime casts', function () {
    $notification = new Notification();

    expect($notification->getFillable())->toContain('message')
        ->and($notification->getFillable())->toContain('channels')
        ->and($notification->getCasts())->toHaveKey('data')
        ->and($notification->getCasts())->toHaveKey('read_at');
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

    expect($template->getFillable())->toContain('grapesjs_data')
        ->and($template->exposedCasts())->toHaveKey('channels')
        ->and($compiled)->toHaveKeys(['subject', 'body_html', 'body_text'])
        ->and($preview)->toHaveKeys(['subject', 'body_html', 'body_text'])
        ->and($template->shouldSend(['foo' => 'bar']))->toBeTrue();

    $template->conditions = ['foo' => 'bar'];
    expect($template->shouldSend(['foo' => 'bar']))->toBeTrue()
        ->and($template->shouldSend(['foo' => 'baz']))->toBeFalse();
});

test('notify theme exposes logo accessor and morph relation', function () {
    $theme = new NotifyTheme();
    $theme->logo_width = 300;
    $theme->logo_height = 120;

    $logo = $theme->getLogoAttribute(null);
    $relation = $theme->linkable();

    expect($theme->getConnectionName())->toBe('notify')
        ->and($theme->getFillable())->toContain('logo_src')
        ->and($theme->getFillable())->toContain('view_params')
        ->and($theme->getCasts())->toHaveKey('view_params')
        ->and($logo['width'])->toBe(300)
        ->and($logo['height'])->toBe(120)
        ->and($relation)->toBeInstanceOf(MorphTo::class);
});
