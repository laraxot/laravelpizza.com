<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notify\Models\Contact;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

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
        ];

        $this->assertEquals($expectedCasts, $contact->casts());
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

        $this->assertNotNull($contact->fresh()->verified_at);
        $this->assertEquals('new-token-123', $contact->fresh()->token);
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
        $this->assertEquals('email', $emailContacts[0]->contact_type);
        $this->assertEquals('phone', $phoneContacts[0]->contact_type);
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
        $this->assertEquals('456', $user456Contacts[0]->user_id);
        $this->assertEquals('456', $user456Contacts[1]->user_id);
        $this->assertEquals('789', $user789Contacts[0]->user_id);
    }

    /** @test */
    public function it_can_find_by_email(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'email',
            'value' => 'test@example.com',
            'email' => 'test@example.com',
        ]);

        $foundContact = Contact::where('email', 'test@example.com')->first();

        $this->assertNotNull($foundContact);
        $this->assertEquals($contact->id, $foundContact->id);
        $this->assertEquals('test@example.com', $foundContact->email);
    }

    /** @test */
    public function it_can_find_by_mobile_phone(): void
    {
        $contact = Contact::create([
            'model_type' => 'App\Models\User',
            'model_id' => '123',
            'contact_type' => 'phone',
            'value' => '+393331234567',
            'mobile_phone' => '+393331234567',
        ]);

        $foundContact = Contact::where('mobile_phone', '+393331234567')->first();

        $this->assertNotNull($foundContact);
        $this->assertEquals($contact->id, $foundContact->id);
        $this->assertEquals('+393331234567', $foundContact->mobile_phone);
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
        $this->assertEquals('John', $johnContacts[0]->first_name);
        $this->assertEquals('Doe', $doeContacts[0]->last_name);
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
        $this->assertNotNull($verifiedContacts[0]->verified_at);
        $this->assertNull($unverifiedContacts[0]->verified_at);
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
        $this->assertEquals('200', $deliveredSms[0]->sms_status_code);
        $this->assertEquals('400', $failedSms[0]->sms_status_code);
        $this->assertEquals('Delivered', $deliveredSms[0]->sms_status_txt);
        $this->assertEquals('Failed', $failedSms[0]->sms_status_txt);
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
        $this->assertEquals(1, $lowSmsContacts[0]->sms_count);
        $this->assertEquals(25, $highMailContacts[0]->mail_count);
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
        $this->assertEquals('Manager', $managers[0]->attribute_2);
        $this->assertEquals('IT Department', $itDepartment[0]->attribute_3);
        $this->assertEquals('IT Department', $itDepartment[1]->attribute_3);
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
        $this->assertEquals('verified@example.com', $verifiedManagers[0]->value);
        $this->assertEquals('Manager', $verifiedManagers[0]->attribute_1);
        $this->assertEquals(5, $verifiedManagers[0]->sms_count);
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
            'email' => null,
            'mobile_phone' => null,
            'verified_at' => null,
            'token' => null,
        ]);

        $this->assertNull($contact->first_name);
        $this->assertNull($contact->last_name);
        $this->assertNull($contact->email);
        $this->assertNull($contact->mobile_phone);
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
        $this->assertEquals('first@example.com', $orderedContacts[0]->value);
        $this->assertEquals('second@example.com', $orderedContacts[1]->value);
        $this->assertEquals('third@example.com', $orderedContacts[2]->value);
        $this->assertEquals(1, $orderedContacts[0]->order_column);
        $this->assertEquals(2, $orderedContacts[1]->order_column);
        $this->assertEquals(3, $orderedContacts[2]->order_column);
    }
}
