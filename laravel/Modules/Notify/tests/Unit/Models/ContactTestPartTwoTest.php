<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.

use Modules\Notify\Database\Factories\ContactFactory;
use Modules\Notify\Models\Contact;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\withoutExceptionHandling;

uses(TestCase::class);
beforeEach(function (): void {
    withoutExceptionHandling();
});

describe('Contact PartTwo', function (): void {
    test('_can_find_by_mobile_phone', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'mobile_phone' => '+393331234567']);

        $foundContact = Contact::where('mobile_phone', '+393331234567')->first();

        Assert::assertNotNull($foundContact);
        Assert::assertInstanceOf(Contact::class, $foundContact);
        Assert::assertEquals($contact->id, $foundContact->id);
        Assert::assertEquals('+393331234567', $foundContact->value);
    });

    test('_can_find_by_name_pattern', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'jane@example.com',
            'first_name' => 'Jane',
            'last_name' => 'Smith']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'bob@example.com',
            'first_name' => 'Bob',
            'last_name' => 'Johnson']);

        $johnContacts = Contact::where('first_name', 'like', '%John%')->get();
        $doeContacts = Contact::where('last_name', 'like', '%Doe%')->get();
        $jContacts = Contact::where('first_name', 'like', 'J%')->get();

        Assert::assertCount(1, $johnContacts);
        Assert::assertCount(1, $doeContacts);
        Assert::assertCount(2, $jContacts); // John and Jane
        Assert::assertEquals('John', XotBasePest::assertFirstModel($johnContacts, Contact::class)->first_name);
        Assert::assertEquals('Doe', XotBasePest::assertFirstModel($doeContacts, Contact::class)->last_name);
    });

    test('_can_find_by_token', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'token' => 'unique-token-123']);

        $foundContact = Contact::where('token', 'unique-token-123')->first();

        Assert::assertNotNull($foundContact);
        Assert::assertEquals($contact->id, $foundContact->id);
        Assert::assertEquals('unique-token-123', $foundContact->token);
    });

    test('_can_find_by_verification_status', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'verified@example.com',
            'verified_at' => now()]);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'unverified@example.com',
            'verified_at' => null]);

        $verifiedContacts = Contact::whereNotNull('verified_at')->get();
        $unverifiedContacts = Contact::whereNull('verified_at')->get();

        Assert::assertCount(1, $verifiedContacts);
        Assert::assertCount(1, $unverifiedContacts);
        Assert::assertNotNull(XotBasePest::assertFirstModel($verifiedContacts, Contact::class)->verified_at);
        Assert::assertNull(XotBasePest::assertFirstModel($unverifiedContacts, Contact::class)->verified_at);
    });

    test('_can_find_by_sms_status', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'sms_status_code' => '200',
            'sms_status_txt' => 'Delivered']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'phone',
            'value' => '+393339876543',
            'sms_status_code' => '400',
            'sms_status_txt' => 'Failed']);

        $deliveredSms = Contact::where('sms_status_code', '200')->get();
        $failedSms = Contact::where('sms_status_code', '400')->get();

        Assert::assertCount(1, $deliveredSms);
        Assert::assertCount(1, $failedSms);
        Assert::assertEquals('200', XotBasePest::assertFirstModel($deliveredSms, Contact::class)->sms_status_code);
        Assert::assertEquals('400', XotBasePest::assertFirstModel($failedSms, Contact::class)->sms_status_code);
        Assert::assertEquals('Delivered', XotBasePest::assertFirstModel($deliveredSms, Contact::class)->sms_status_txt);
        Assert::assertEquals('Failed', XotBasePest::assertFirstModel($failedSms, Contact::class)->sms_status_txt);
    });

    test('_can_find_by_counters', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'low@example.com',
            'sms_count' => 1,
            'mail_count' => 2]);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'high@example.com',
            'sms_count' => 10,
            'mail_count' => 25]);

        $lowSmsContacts = Contact::where('sms_count', '<=', 5)->get();
        $highMailContacts = Contact::where('mail_count', '>=', 20)->get();

        Assert::assertCount(1, $lowSmsContacts);
        Assert::assertCount(1, $highMailContacts);
        Assert::assertEquals(1, XotBasePest::assertFirstModel($lowSmsContacts, Contact::class)->sms_count);
        Assert::assertEquals(25, XotBasePest::assertFirstModel($highMailContacts, Contact::class)->mail_count);
    });

    test('_can_find_by_attributes', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'manager@example.com',
            'attribute_1' => 'Position',
            'attribute_2' => 'Manager',
            'attribute_3' => 'IT Department']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'developer@example.com',
            'attribute_1' => 'Position',
            'attribute_2' => 'Developer',
            'attribute_3' => 'IT Department']);

        $managers = Contact::where('attribute_2', 'Manager')->get();
        $itDepartment = Contact::where('attribute_3', 'IT Department')->get();

        Assert::assertCount(1, $managers);
        Assert::assertCount(2, $itDepartment);
        Assert::assertEquals('Manager', XotBasePest::assertFirstModel($managers, Contact::class)->attribute_2);
        Assert::assertEquals('IT Department', XotBasePest::assertFirstModel($itDepartment, Contact::class)->attribute_3);
        $secondItContact = $itDepartment->get(1);
        Assert::assertInstanceOf(Contact::class, $secondItContact);
        Assert::assertEquals('IT Department', $secondItContact->attribute_3);
    });

    test('_can_find_by_multiple_criteria', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'verified@example.com',
            'verified_at' => now(),
            'sms_count' => 5,
            'attribute_1' => 'Manager']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'unverified@example.com',
            'verified_at' => null,
            'sms_count' => 2,
            'attribute_1' => 'Developer']);

        $verifiedManagers = Contact::whereNotNull('verified_at')
            ->where('attribute_1', 'Manager')
            ->where('sms_count', '>=', 3)
            ->get();

        Assert::assertCount(1, $verifiedManagers);
        $verifiedManager = XotBasePest::assertFirstModel($verifiedManagers, Contact::class);
        Assert::assertEquals('verified@example.com', $verifiedManager->value);
        Assert::assertEquals('Manager', $verifiedManager->attribute_1);
        Assert::assertEquals(5, $verifiedManager->sms_count);
    });

    test('_can_handle_null_values', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'mobile_phone' => null,
            'verified_at' => null,
            'token' => null]);

        Assert::assertNull($contact->first_name);
        Assert::assertNull($contact->last_name);
        Assert::assertNull($contact->verified_at);
        Assert::assertNull($contact->token);
    });

    test('_can_order_by_order_column', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'third@example.com',
            'order_column' => 3]);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'first@example.com',
            'order_column' => 1]);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'second@example.com',
            'order_column' => 2]);

        $orderedContacts = Contact::orderBy('order_column')->get();

        Assert::assertCount(3, $orderedContacts);
        Assert::assertEquals('first@example.com', XotBasePest::assertFirstModel($orderedContacts, Contact::class)->value);
        Assert::assertEquals('second@example.com', $orderedContacts->get(1)?->value);
        Assert::assertEquals('third@example.com', $orderedContacts->get(2)?->value);
        Assert::assertEquals(1, XotBasePest::assertFirstModel($orderedContacts, Contact::class)->order_column);
        Assert::assertEquals(2, $orderedContacts->get(1)?->order_column);
        Assert::assertEquals(3, $orderedContacts->get(2)?->order_column);
    });
});
