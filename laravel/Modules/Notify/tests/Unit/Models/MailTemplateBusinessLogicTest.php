<?php

declare(strict_types=1);

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Mailable as LaravelMailable;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;
use Spatie\Sluggable\HasSlug;
use Spatie\Translatable\HasTranslations;

uses(TestCase::class);
describe('MailTemplate Business Logic', function (): void {
    test('mail template extends spatie mail template', function (): void {
        Assert::assertSame(SpatieMailTemplate::class, get_parent_class(MailTemplate::class));
    });

    test('mail template has slug trait for url-friendly names', function (): void {
        $traits = \Safe\class_uses(MailTemplate::class);

        Assert::assertArrayHasKey(HasSlug::class, $traits);
    });

    test('mail template has translations trait', function (): void {
        $traits = \Safe\class_uses(MailTemplate::class);

        Assert::assertArrayHasKey(HasTranslations::class, $traits);
    });

    test('mail template has soft deletes trait', function (): void {
        $traits = \Safe\class_uses(MailTemplate::class);

        Assert::assertArrayHasKey(SoftDeletes::class, $traits);
    });

    test('mail template can store template content', function (): void {
        $mailTemplate = new MailTemplate;
        $mailTemplate->name = 'Welcome Email';
        $mailTemplate->subject = 'Welcome to our platform';
        $mailTemplate->html_template = '<h1>Welcome!</h1>';

        Assert::assertSame('Welcome Email', $mailTemplate->name);
        Assert::assertSame('Welcome to our platform', $mailTemplate->subject);
        Assert::assertSame('<h1>Welcome!</h1>', $mailTemplate->html_template);
    });

    test('mail template can link to mailable class', function (): void {
        $mailTemplate = new MailTemplate;
        $mailTemplate->mailable = 'App\\Mail\\WelcomeMail';

        Assert::assertSame('App\\Mail\\WelcomeMail', $mailTemplate->mailable);
    });

    test('mail template has version tracking', function (): void {
        $mailTemplate = new MailTemplate;
        $mailTemplate->version = 2;

        Assert::assertSame(2, $mailTemplate->version);
    });

    test('mail template can store optional text template', function (): void {
        $mailTemplate = new MailTemplate;
        $mailTemplate->text_template = 'Welcome! This is plain text.';

        Assert::assertSame('Welcome! This is plain text.', $mailTemplate->text_template);
    });

    test('mail template can be queried by mailable', function (): void {
        $mailable = new class extends LaravelMailable implements Mailable
        {
            public function build(): static
            {
                return $this;
            }

            public function getSlug(): string
            {
                return 'business-logic-mailable';
            }
        };
        $query = MailTemplate::forMailable($mailable);

        Assert::assertInstanceOf(Builder::class, $query);
        Assert::assertStringContainsString('slug', $query->toSql());
    });

    test('mail template has creator and updater tracking', function (): void {
        $mailTemplate = new MailTemplate;
        $mailTemplate->created_by = 'user-1';
        $mailTemplate->updated_by = 'user-2';

        Assert::assertSame('user-1', $mailTemplate->created_by);
        Assert::assertSame('user-2', $mailTemplate->updated_by);
    });
});
