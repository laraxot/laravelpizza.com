<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Models\Contact;
use Modules\Notify\Tests\TestCase;

uses(\Modules\Notify\Tests\TestCase::class);
class ContactTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_contact(): void
    {
        $contact = Contact::create([
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
            'order_column' => 1,
        ]);

        $this->assertDatabaseHas('contacts', [
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
            'order_column' => 1,
        ]);

        $this->assertInstanceOf(Contact::class, $contact);
    }

    /** @test */
    public function it_has_correct_fillable_fields(): void
    {
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
            'token',
        ];

        $this->assertEquals($expectedFillable, $contact->getFillable());
    }

    /** @test */
    public function it_has_correct_casts(): void
    {
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
            'user_id' => 'string',
            'mail_sent_at' => 'datetime',
            'sms_sent_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $contact->getCasts());
    }

    /** @test */
    public function it_can_store_contact_with_minimal_fields(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
        ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
        ]);

        $this->assertInstanceOf(Contact::class, $contact);
    }

    /** @test */
    public function it_can_store_contact_with_all_attributes(): void
    {
        $contact = Contact::create([
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
            'order_column' => 2,
        ]);

        $this->assertDatabaseHas('contacts', [
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
            'order_column' => 2,
        ]);
    }

    /** @test */
    public function it_can_update_contact(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'old@example.com',
            'first_name' => 'Old Name',
            'last_name' => 'Old Surname',
            'email' => 'old.email@example.com',
            'mobile_phone' => '+393330000000',
        ]);

        $contact->update([
            'value' => 'new@example.com',
            'first_name' => 'New Name',
            'last_name' => 'New Surname',
            'email' => 'new.email@example.com',
            'mobile_phone' => '+393331111111',
            'verified_at' => now(),
            'token' => 'new-token-123',
        ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'value' => 'new@example.com',
            'first_name' => 'New Name',
            'last_name' => 'New Surname',
            'email' => 'new.email@example.com',
            'mobile_phone' => '+393331111111',
        ]);

        $this->assertNotNull($contact->refresh()->verified_at);
        $this->assertEquals('new-token-123', $contact->refresh()->token);
    }

    /** @test */
    public function it_can_find_by_model_type_and_id(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
        ]);

        $foundContact = Contact::where('model_type', 'App\Models\User')->where('model_id', '123')->first();

        $this->assertNotNull($foundContact);
        $this->assertEquals($contact->id, $foundContact->id);
        $this->assertEquals('App\Models\User', $foundContact->model_type);
        $this->assertEquals('123', $foundContact->model_id);
    }

    /** @test */
    public function it_can_find_by_contact_type(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'email@example.com',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'phone',
            'value' => '+393331234567',
        ]);

        Contact::create([
            'model_type' => 'App\Models\Company',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'company@example.com',
        ]);

        $emailContacts = Contact::where('contact_type', 'email')->get();
        $phoneContacts = Contact::where('contact_type', 'phone')->get();

        $this->assertCount(2, $emailContacts);
        $this->assertCount(1, $phoneContacts);
        $this->assertEquals('email', $emailContacts->firstOrFail()->contact_type);
        $this->assertEquals('phone', $phoneContacts->firstOrFail()->contact_type);
    }

    /** @test */
    public function it_can_find_by_user_id(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'user1@example.com',
            'user_id' => '456',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'user_id' => '456',
        ]);

        Contact::create([
            'model_type' => 'App\Models\Company',
            'model_id' => '101',
            'contact_type' => 'email',
            'value' => 'company@example.com',
            'user_id' => '789',
        ]);

        $user456Contacts = Contact::where('user_id', '456')->get();
        $user789Contacts = Contact::where('user_id', '789')->get();

        $this->assertCount(2, $user456Contacts);
        $this->assertCount(1, $user789Contacts);
        $this->assertEquals('456', $user456Contacts->firstOrFail()->user_id);
        $this->assertEquals('456', $user456Contacts->skip(1)->firstOrFail()->user_id);
        $this->assertEquals('789', $user789Contacts->firstOrFail()->user_id);
    }

    /** @test */
    public function it_can_find_by_email(): void
    {
        $this->markTestSkipped('Contact::email not implemented: il valore sta in `value` con `contact_type`.');
    }

    /** @test */
    public function it_can_find_by_mobile_phone(): void
    {
        $this->markTestSkipped('Contact::mobile_phone not implemented: il valore sta in `value` con `contact_type`.');
    }

    /** @test */
    public function it_can_find_by_name_pattern(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'jane@example.com',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'bob@example.com',
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
        ]);

        $johnContacts = Contact::where('first_name', 'like', '%John%')->get();
        $doeContacts = Contact::where('last_name', 'like', '%Doe%')->get();
        $jContacts = Contact::where('first_name', 'like', 'J%')->get();

        $this->assertCount(1, $johnContacts);
        $this->assertCount(1, $doeContacts);
        $this->assertCount(2, $jContacts); // John and Jane
        $this->assertEquals('John', $johnContacts->firstOrFail()->first_name);
        $this->assertEquals('Doe', $doeContacts->firstOrFail()->last_name);
    }

    /** @test */
    public function it_can_find_by_token(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'token' => 'unique-token-123',
        ]);

        $foundContact = Contact::where('token', 'unique-token-123')->first();

        $this->assertNotNull($foundContact);
        $this->assertEquals($contact->id, $foundContact->id);
        $this->assertEquals('unique-token-123', $foundContact->token);
    }

    /** @test */
    public function it_can_find_by_verification_status(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'verified@example.com',
            'verified_at' => now(),
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'unverified@example.com',
            'verified_at' => null,
        ]);

        $verifiedContacts = Contact::whereNotNull('verified_at')->get();
        $unverifiedContacts = Contact::whereNull('verified_at')->get();

        $this->assertCount(1, $verifiedContacts);
        $this->assertCount(1, $unverifiedContacts);
        $this->assertNotNull($verifiedContacts->firstOrFail()->verified_at);
        $this->assertNull($unverifiedContacts->firstOrFail()->verified_at);
    }

    /** @test */
    public function it_can_find_by_sms_status(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'sms_status_code' => '200',
            'sms_status_txt' => 'Delivered',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'phone',
            'value' => '+393339876543',
            'sms_status_code' => '400',
            'sms_status_txt' => 'Failed',
        ]);

        $deliveredSms = Contact::where('sms_status_code', '200')->get();
        $failedSms = Contact::where('sms_status_code', '400')->get();

        $this->assertCount(1, $deliveredSms);
        $this->assertCount(1, $failedSms);
        $this->assertEquals('200', $deliveredSms->firstOrFail()->sms_status_code);
        $this->assertEquals('400', $failedSms->firstOrFail()->sms_status_code);
        $this->assertEquals('Delivered', $deliveredSms->firstOrFail()->sms_status_txt);
        $this->assertEquals('Failed', $failedSms->firstOrFail()->sms_status_txt);
    }

    /** @test */
    public function it_can_find_by_counters(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'low@example.com',
            'sms_count' => 1,
            'mail_count' => 2,
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'high@example.com',
            'sms_count' => 10,
            'mail_count' => 25,
        ]);

        $lowSmsContacts = Contact::where('sms_count', '<=', 5)->get();
        $highMailContacts = Contact::where('mail_count', '>=', 20)->get();

        $this->assertCount(1, $lowSmsContacts);
        $this->assertCount(1, $highMailContacts);
        $this->assertEquals(1, $lowSmsContacts->firstOrFail()->sms_count);
        $this->assertEquals(25, $highMailContacts->firstOrFail()->mail_count);
    }

    /** @test */
    public function it_can_find_by_attributes(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'manager@example.com',
            'attribute_1' => 'Position',
            'attribute_2' => 'Manager',
            'attribute_3' => 'IT Department',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'developer@example.com',
            'attribute_1' => 'Position',
            'attribute_2' => 'Developer',
            'attribute_3' => 'IT Department',
        ]);

        $managers = Contact::where('attribute_2', 'Manager')->get();
        $itDepartment = Contact::where('attribute_3', 'IT Department')->get();

        $this->assertCount(1, $managers);
        $this->assertCount(2, $itDepartment);
        $this->assertEquals('Manager', $managers->firstOrFail()->attribute_2);
        $this->assertEquals('IT Department', $itDepartment->firstOrFail()->attribute_3);
        $this->assertEquals('IT Department', $itDepartment->skip(1)->firstOrFail()->attribute_3);
    }

    /** @test */
    public function it_can_find_by_multiple_criteria(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'verified@example.com',
            'verified_at' => now(),
            'sms_count' => 5,
            'attribute_1' => 'Manager',
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'unverified@example.com',
            'verified_at' => null,
            'sms_count' => 2,
            'attribute_1' => 'Developer',
        ]);

        $verifiedManagers = Contact::whereNotNull('verified_at')
            ->where('attribute_1', 'Manager')
            ->where('sms_count', '>=', 3)
            ->get();

        $this->assertCount(1, $verifiedManagers);
        $this->assertEquals('verified@example.com', $verifiedManagers->firstOrFail()->value);
        $this->assertEquals('Manager', $verifiedManagers->firstOrFail()->attribute_1);
        $this->assertEquals(5, $verifiedManagers->firstOrFail()->sms_count);
    }

    /** @test */
    public function it_can_handle_null_values(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'first_name' => null,
            'last_name' => null,
            'verified_at' => null,
            'token' => null,
        ]);

        $this->assertNull($contact->first_name);
        $this->assertNull($contact->last_name);
        $this->assertNull($contact->verified_at);
        $this->assertNull($contact->token);
    }

    /** @test */
    public function it_can_order_by_order_column(): void
    {
        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'third@example.com',
            'order_column' => 3,
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '456',
            'contact_type' => 'email',
            'value' => 'first@example.com',
            'order_column' => 1,
        ]);

        Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '789',
            'contact_type' => 'email',
            'value' => 'second@example.com',
            'order_column' => 2,
        ]);

        $orderedContacts = Contact::orderBy('order_column')->get();

        $this->assertCount(3, $orderedContacts);
        $this->assertEquals('first@example.com', $orderedContacts->firstOrFail()->value);
        $this->assertEquals('second@example.com', $orderedContacts->skip(1)->firstOrFail()->value);
        $this->assertEquals('third@example.com', $orderedContacts->skip(2)->firstOrFail()->value);
        $this->assertEquals(1, $orderedContacts->firstOrFail()->order_column);
        $this->assertEquals(2, $orderedContacts->skip(1)->firstOrFail()->order_column);
        $this->assertEquals(3, $orderedContacts->skip(2)->firstOrFail()->order_column);
    }
}
