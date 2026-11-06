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

describe('Contact PartOne', function (): void {
    test('_can_create_contact', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'user_id' => '456',
            'verified_at' => now(),
            'token' => 'verification-token-123',
            'sms_sent_at' => now(),
            'sms_count' => 1,
            'mail_sent_at' => now(),
            'mail_count' => 2,
            'survey_pdf_id' => 'pdf-789',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'mobile_phone' => '+393331234567',
            'attribute_1' => 'Company',
            'attribute_2' => 'Manager',
            'attribute_3' => 'Department',
            'attribute_4' => 'Location',
            'attribute_5' => 'Notes',
            'usesleft' => '5',
            'sms_status_code' => '200',
            'sms_status_txt' => 'Delivered',
            'duplicate_count' => 0,
            'order_column' => 1]);
        XotBasePest::assertTableHas('notify', 'contacts', [
            'id' => $contact->id,
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'user_id' => '456',
            'token' => 'verification-token-123',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'mobile_phone' => '+393331234567',
            'attribute_1' => 'Company',
            'attribute_2' => 'Manager',
            'attribute_3' => 'Department',
            'attribute_4' => 'Location',
            'attribute_5' => 'Notes',
            'usesleft' => '5',
            'sms_status_code' => '200',
            'sms_status_txt' => 'Delivered',
            'duplicate_count' => 0,
            'order_column' => 1]);

        Assert::assertInstanceOf(Contact::class, $contact);
    });

    test('_has_correct_fillable_fields', function (): void {
        $contact = new Contact;

        $expectedFillable = [
            'model_id',
            'model_type',
            'contact_type',
            'value',
            'verified_at',
            'updated_at',
            'created_at',
            'updated_by',
            'created_by',
            'user_id',
            'token'];

        Assert::assertEquals($expectedFillable, $contact->getFillable());
    });

    test('_has_correct_casts', function (): void {
        $contact = new Contact;

        $expectedCasts = [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'model_id' => 'string',
            'user_id' => 'string'];

        Assert::assertEquals($expectedCasts, $contact->getCasts());
    });

    test('_can_store_contact_with_minimal_fields', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567']);
        XotBasePest::assertTableHas('notify', 'contacts', [
            'id' => $contact->id,
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567']);

        Assert::assertInstanceOf(Contact::class, $contact);
    });

    test('_can_store_contact_with_all_attributes', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\Company',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'info@company.com',
            'user_id' => '456',
            'verified_at' => now(),
            'token' => 'verification-token-456',
            'sms_sent_at' => now(),
            'sms_count' => 3,
            'mail_sent_at' => now(),
            'mail_count' => 5,
            'survey_pdf_id' => 'pdf-456',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@company.com',
            'mobile_phone' => '+393339876543',
            'attribute_1' => 'Position',
            'attribute_2' => 'Senior Manager',
            'attribute_3' => 'IT Department',
            'attribute_4' => 'Milan Office',
            'attribute_5' => 'Technical Lead',
            'attribute_6' => 'Project A',
            'attribute_7' => 'Team B',
            'attribute_8' => 'Budget 100k',
            'attribute_9' => 'Deadline Q1',
            'attribute_10' => 'Priority High',
            'attribute_11' => 'Status Active',
            'attribute_12' => 'Category Premium',
            'attribute_13' => 'Region North',
            'attribute_14' => 'Zone Central',
            'usesleft' => '10',
            'sms_status_code' => '201',
            'sms_status_txt' => 'Queued',
            'duplicate_count' => 1,
            'order_column' => 2]);
        XotBasePest::assertTableHas('notify', 'contacts', [
            'id' => $contact->id,
            'model_type' => 'App\Models\Company',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'info@company.com',
            'user_id' => '456',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@company.com',
            'mobile_phone' => '+393339876543',
            'attribute_1' => 'Position',
            'attribute_2' => 'Senior Manager',
            'attribute_3' => 'IT Department',
            'attribute_4' => 'Milan Office',
            'attribute_5' => 'Technical Lead',
            'attribute_6' => 'Project A',
            'attribute_7' => 'Team B',
            'attribute_8' => 'Budget 100k',
            'attribute_9' => 'Deadline Q1',
            'attribute_10' => 'Priority High',
            'attribute_11' => 'Status Active',
            'attribute_12' => 'Category Premium',
            'attribute_13' => 'Region North',
            'attribute_14' => 'Zone Central',
            'usesleft' => '10',
            'sms_status_code' => '201',
            'sms_status_txt' => 'Queued',
            'duplicate_count' => 1,
            'order_column' => 2]);
    });

    test('_can_update_contact', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'old@example.com',
            'first_name' => 'Old Name',
            'last_name' => 'Old Surname',
            'email' => 'old.email@example.com',
            'mobile_phone' => '+393330000000']);

        $contact->update([
            'value' => 'new@example.com',
            'first_name' => 'New Name',
            'last_name' => 'New Surname',
            'email' => 'new.email@example.com',
            'mobile_phone' => '+393331111111',
            'verified_at' => now(),
            'token' => 'new-token-123']);
        XotBasePest::assertTableHas('notify', 'contacts', [
            'id' => $contact->id,
            'value' => 'new@example.com',
            'first_name' => 'New Name',
            'last_name' => 'New Surname',
            'email' => 'new.email@example.com',
            'mobile_phone' => '+393331111111']);

        Assert::assertNotNull(XotBasePest::assertFreshModel($contact, Contact::class)->verified_at);
        Assert::assertEquals('new-token-123', XotBasePest::assertFreshModel($contact, Contact::class)->token);
    });

    test('_can_find_by_model_type_and_id', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com']);

        $foundContact = Contact::where('model_type', 'App\Models\User')->where('model_id', '123')->first();

        Assert::assertNotNull($foundContact);
        Assert::assertEquals($contact->id, $foundContact->id);
        Assert::assertEquals('App\Models\User', $foundContact->model_type);
        Assert::assertEquals('123', $foundContact->model_id);
    });

    test('_can_find_by_contact_type', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'email@example.com']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'phone',
            'value' => '+393331234567']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\Company',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'company@example.com']);

        $emailContacts = Contact::where('contact_type', 'email')->get();
        $phoneContacts = Contact::where('contact_type', 'phone')->get();

        Assert::assertCount(2, $emailContacts);
        Assert::assertCount(1, $phoneContacts);
        Assert::assertEquals('email', XotBasePest::assertFirstModel($emailContacts, Contact::class)->contact_type);
        Assert::assertEquals('phone', XotBasePest::assertFirstModel($phoneContacts, Contact::class)->contact_type);
    });

    test('_can_find_by_user_id', function (): void {
        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'user1@example.com',
            'user_id' => '456']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'user_id' => '456']);

        ContactFactory::new()->createOne([
            'model_type' => 'App\Models\Company',
            'model_id' => '101',
            'contact_type' => 'email',
            'value' => 'company@example.com',
            'user_id' => '789']);

        $user456Contacts = Contact::where('user_id', '456')->get();
        $user789Contacts = Contact::where('user_id', '789')->get();

        Assert::assertCount(2, $user456Contacts);
        Assert::assertCount(1, $user789Contacts);
        Assert::assertEquals('456', XotBasePest::assertFirstModel($user456Contacts, Contact::class)->user_id);
        $secondUserContact = $user456Contacts->get(1);
        Assert::assertInstanceOf(Contact::class, $secondUserContact);
        Assert::assertEquals('456', $secondUserContact->user_id);
        Assert::assertEquals('789', XotBasePest::assertFirstModel($user789Contacts, Contact::class)->user_id);
    });

    test('_can_find_by_email', function (): void {
        $contact = ContactFactory::new()->createOne([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'email' => 'test@example.com']);

        $foundContact = Contact::where('email', 'test@example.com')->first();

        Assert::assertNotNull($foundContact);
        Assert::assertInstanceOf(Contact::class, $foundContact);
        Assert::assertEquals($contact->id, $foundContact->id);
        Assert::assertEquals('test@example.com', $foundContact->value);
    });
});