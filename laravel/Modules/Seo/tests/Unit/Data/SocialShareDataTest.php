<?php

declare(strict_types=1);

use Modules\Seo\Data\SocialShareData;
use Tests\TestCase;

uses(TestCase::class);

it('creates instance with required url', function (): void {
    $data = new SocialShareData(url: 'https://laravelpizza.com');

    expect($data->url)->toBe('https://laravelpizza.com')
        ->and($data->title)->toBeNull()
        ->and($data->text)->toBeNull()
        ->and($data->image)->toBeNull()
        ->and($data->hashtags)->toBeNull()
        ->and($data->via)->toBeNull();
});

it('has default platforms list', function (): void {
    $data = new SocialShareData(url: 'https://laravelpizza.com');

    expect($data->platforms)->toBe(['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy']);
});

it('accepts all optional fields', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com/events/laravel-pizza-1',
        title: 'Laravel Pizza Meetup',
        text: 'Join us for pizza and Laravel!',
        image: 'https://laravelpizza.com/images/og.png',
        hashtags: 'laravel,php,meetup',
        via: 'laravelpizza',
        platforms: ['twitter', 'linkedin'],
    );

    expect($data->url)->toBe('https://laravelpizza.com/events/laravel-pizza-1')
        ->and($data->title)->toBe('Laravel Pizza Meetup')
        ->and($data->text)->toBe('Join us for pizza and Laravel!')
        ->and($data->image)->toBe('https://laravelpizza.com/images/og.png')
        ->and($data->hashtags)->toBe('laravel,php,meetup')
        ->and($data->via)->toBe('laravelpizza')
        ->and($data->platforms)->toBe(['twitter', 'linkedin']);
});

it('can override platforms with custom list', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com',
        platforms: ['twitter'],
    );

    expect($data->platforms)->toBe(['twitter'])
        ->and($data->platforms)->toHaveCount(1);
});

it('serializes to array via Spatie Data', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com',
        title: 'Laravel Pizza',
    );

    $array = $data->toArray();

    expect($array)->toHaveKey('url', 'https://laravelpizza.com')
        ->and($array)->toHaveKey('title', 'Laravel Pizza');
});
