<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Database\Factories\ContactFactory;
use Modules\Notify\Models\Contact;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Contact Management Business Logic', function () {
    it('can create contact with basic information', function () {
        $contactData = [
            'model_type' => 'Modules\User\Models\User',
            'model_id' => 'user-'.uniqid(),
            'contact_type' => 'email',
            'value' => 'mario.rossi@example.com',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
        ];

        $contact = ContactFactory::new()->createOne($contactData);

        Assert::assertSame('Mario', $contact->first_name);
        Assert::assertSame('Rossi', $contact->last_name);
        Assert::assertSame('email', $contact->contact_type);
        Assert::assertSame('mario.rossi@example.com', $contact->value);

        \assertNotifyTableHas('contacts', [
            'id' => $contact->id,
            'contact_type' => 'email',
            'value' => 'mario.rossi@example.com',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
        ]);
    });

    it('can update contact verification state', function () {
        $contact = ContactFactory::new()->createOne([
            'contact_type' => 'email',
            'value' => 'verify@example.com',
            'verified_at' => null,
        ]);

        $verifiedAt = now()->toDateTimeString();
        $contact->update(['verified_at' => $verifiedAt]);

        $fresh = \assertFreshModel($contact, Contact::class);

        Assert::assertSame($verifiedAt, $fresh->verified_at);

        \assertNotifyTableHas('contacts', [
            'id' => $contact->id,
            'verified_at' => $verifiedAt,
        ]);
    });

    it('can track sms and mail counters', function () {
        $contact = ContactFactory::new()->createOne([
            'contact_type' => 'mobile_phone',
            'value' => '+393331234567',
            'sms_count' => 0,
            'mail_count' => 0,
        ]);

        $contact->update([
            'sms_count' => 2,
            'mail_count' => 1,
            'sms_status_code' => '200',
            'sms_status_txt' => 'Delivered',
        ]);

        $fresh = \assertFreshModel($contact, Contact::class);

        Assert::assertSame(2, $fresh->sms_count);
        Assert::assertSame(1, $fresh->mail_count);
        Assert::assertSame('200', $fresh->sms_status_code);
        Assert::assertSame('Delivered', $fresh->sms_status_txt);
    });

    it('can store extended attributes', function () {
        $contact = ContactFactory::new()->createOne([
            'attribute_1' => 'Studio Dentistico Milano',
            'attribute_2' => 'Referente',
            'usesleft' => '3',
            'order_column' => 10,
        ]);

        $fresh = \assertFreshModel($contact, Contact::class);

        Assert::assertSame('Studio Dentistico Milano', $fresh->attribute_1);
        Assert::assertSame('Referente', $fresh->attribute_2);
        Assert::assertSame('3', $fresh->usesleft);
        Assert::assertSame(10, $fresh->order_column);
    });
});
