<?php

declare(strict_types=1);

use Modules\Notify\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeNotification', fn () => $this->toBeInstanceOf(\Modules\Notify\Models\Notification::class));
expect()->extend('toBeMailTemplate', fn () => $this->toBeInstanceOf(\Modules\Notify\Models\MailTemplate::class));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createNotification(array $attributes = []): \Modules\Notify\Models\Notification
{
    return \Modules\Notify\Models\Notification::factory()->create($attributes);
}

function makeNotification(array $attributes = []): \Modules\Notify\Models\Notification
{
    return \Modules\Notify\Models\Notification::factory()->make($attributes);
}

function createMailTemplate(array $attributes = []): \Modules\Notify\Models\MailTemplate
{
    return \Modules\Notify\Models\MailTemplate::factory()->create($attributes);
}

function makeMailTemplate(array $attributes = []): \Modules\Notify\Models\MailTemplate
{
    return \Modules\Notify\Models\MailTemplate::factory()->make($attributes);
}
