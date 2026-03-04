<?php

declare(strict_types=1);

uses(\Modules\Notify\Tests\TestCase::class);

use Modules\Notify\Models\Contact;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

describe('Contact Management Business Logic', function () {
    it('can create contact with basic information', function () {
        $contactData = [
            'model_type' => 'App\Models\User',
            'model_id' => '1',
            'contact_type' => 'email',
            'value' => 'test@example.com',
        ];

        $contact = Contact::create($contactData);

        expect($contact)
            ->toBeInstanceOf(Contact::class)
            ->and($contact->contact_type)
            ->toBe('email')
            ->and($contact->value)
            ->toBe('test@example.com');

        assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'contact_type' => 'email',
            'value' => 'test@example.com',
        ]);
    });

    it('can update a contact', function () {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '1',
            'contact_type' => 'email',
            'value' => 'test@example.com',
        ]);

        $contact->update(['value' => 'new@example.com']);

        expect($contact->fresh()->value)->toBe('new@example.com');
    });

    it('can delete a contact', function () {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '1',
            'contact_type' => 'email',
            'value' => 'test@example.com',
        ]);

        $contactId = $contact->id;
        $contact->delete();

        assertDatabaseMissing('contacts', [
            'id' => $contactId,
        ]);
    });
});
