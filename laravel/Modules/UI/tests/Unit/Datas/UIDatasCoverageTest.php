<?php

declare(strict_types=1);

uses(Modules\UI\Tests\TestCase::class);

use Modules\UI\Data\UserData as DataUserData;
use Modules\UI\Datas\SliderData;
use Modules\UI\Datas\SliderDataCollection;
use Modules\UI\Datas\UserData;

// --- SliderData ---

it('SliderData can be instantiated with all fields', function (): void {
    $data = new SliderData(
        desktop_thumbnail: '/img/desktop.jpg',
        mobile_thumbnail: '/img/mobile.jpg',
        desktop_thumbnail_webp: '/img/desktop.webp',
        mobile_thumbnail_webp: '/img/mobile.webp',
        link: '/events',
        title: 'Laravel Meetup',
        short_description: 'Join us!',
        description: 'Full description here',
        action_text: 'Register Now',
    );

    expect($data)->toBeInstanceOf(SliderData::class)
        ->and($data->desktop_thumbnail)->toBe('/img/desktop.jpg')
        ->and($data->mobile_thumbnail)->toBe('/img/mobile.jpg')
        ->and($data->link)->toBe('/events')
        ->and($data->title)->toBe('Laravel Meetup')
        ->and($data->action_text)->toBe('Register Now');
});

it('SliderData sets short_description from description', function (): void {
    $data = new SliderData(
        desktop_thumbnail: null,
        mobile_thumbnail: null,
        desktop_thumbnail_webp: null,
        mobile_thumbnail_webp: null,
        link: null,
        title: null,
        short_description: null,
        description: 'My description',
        action_text: null,
    );

    expect($data->short_description)->toBe('My description');
});

it('SliderData can be instantiated with nulls', function (): void {
    $data = new SliderData(
        desktop_thumbnail: null,
        mobile_thumbnail: null,
        desktop_thumbnail_webp: null,
        mobile_thumbnail_webp: null,
        link: null,
        title: null,
        short_description: null,
        description: null,
        action_text: null,
    );

    expect($data)->toBeInstanceOf(SliderData::class)
        ->and($data->desktop_thumbnail)->toBeNull()
        ->and($data->title)->toBeNull();
});

// --- SliderDataCollection ---

it('SliderDataCollection can be instantiated', function (): void {
    $collection = new SliderDataCollection();

    expect($collection)->toBeInstanceOf(SliderDataCollection::class);
});

it('SliderDataCollection is a Spatie Data class', function (): void {
    $collection = new SliderDataCollection();

    expect($collection)->toBeInstanceOf(\Spatie\LaravelData\Data::class);
});

// --- Datas/UserData ---

it('UI Datas UserData can be instantiated', function (): void {
    $data = new UserData(
        id: 1,
        name: 'Mario Rossi',
        email: 'mario@example.com',
        avatar: null,
        role: 'admin',
        permissions: ['view', 'edit'],
        settings: ['theme' => 'dark'],
    );

    expect($data)->toBeInstanceOf(UserData::class)
        ->and($data->id)->toBe(1)
        ->and($data->name)->toBe('Mario Rossi')
        ->and($data->email)->toBe('mario@example.com')
        ->and($data->avatar)->toBeNull()
        ->and($data->role)->toBe('admin')
        ->and($data->permissions)->toBe(['view', 'edit'])
        ->and($data->settings)->toBe(['theme' => 'dark']);
});

it('UI Datas UserData is a Spatie Data class', function (): void {
    $data = new UserData(1, 'Test', 'test@example.com', null, null, [], []);

    expect($data)->toBeInstanceOf(\Spatie\LaravelData\Data::class);
});

// --- Data/UserData ---

it('UI Data UserData can be instantiated', function (): void {
    $data = new DataUserData(
        id: 42,
        name: 'Luigi Verdi',
        email: 'luigi@example.com',
        avatar: 'avatar.png',
        role: 'user',
        permissions: [],
        settings: [],
    );

    expect($data)->toBeInstanceOf(DataUserData::class)
        ->and($data->id)->toBe(42)
        ->and($data->name)->toBe('Luigi Verdi')
        ->and($data->email)->toBe('luigi@example.com')
        ->and($data->avatar)->toBe('avatar.png');
});

it('UI Data UserData is a Spatie Data class', function (): void {
    $data = new DataUserData(1, 'Test', 'test@example.com', null, null, [], []);

    expect($data)->toBeInstanceOf(\Spatie\LaravelData\Data::class);
});
