<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Models\NotificationType;

describe('NotificationType Business Logic', function () {
    test('notification type extends eloquent model', function () {
        expect(NotificationType::class)->toBeSubclassOf(Model::class);
    });

    test('notification type has expected fillable fields', function () {
        $notificationType = new NotificationType();
        $expectedFillable = [
            'name',
            'description',
            'template',
        ];

        expect($notificationType->getFillable())->toEqual($expectedFillable);
    });

    test('notification type can store basic information', function () {
        $notificationType = new NotificationType();
        $notificationType->name = 'Email Verification';
        $notificationType->description = 'Email verification notification type';
        $notificationType->template = 'email-verification-template';

        expect($notificationType->name)->toBe('Email Verification');
        expect($notificationType->description)->toBe('Email verification notification type');
        expect($notificationType->template)->toBe('email-verification-template');
    });

    test('notification type model can be instantiated without errors', function () {
        $notificationType = new NotificationType();

        expect($notificationType)->toBeInstanceOf(NotificationType::class);
        expect($notificationType)->toBeInstanceOf(Model::class);
    });

    test('notification type can be queried', function () {
        $query = NotificationType::query();

        expect($query)->toBeInstanceOf(Builder::class);
    });
});
