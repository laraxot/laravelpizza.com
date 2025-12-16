<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Models\GdprConsent;
use Modules\Gdpr\Models\GdprDataDeletion;
use Modules\Gdpr\Models\GdprDataExport;
use Modules\Gdpr\Models\GdprRequest;
use Modules\User\Models\User;
use Tests\TestCase;

class GdprBusinessLogicTest extends TestCase
{
    /** @test */
    public function it_can_create_and_manage_gdpr_requests(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $gdprRequest = GdprRequest::factory()->create([
            'user_id' => $user->id,
            'type' => 'data_access',
            'status' => 'pending',
            'description' => 'Request to access personal data',
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_requests', [
            'id' => $gdprRequest->id,
            'user_id' => $user->id,
            'type' => 'data_access',
            'status' => 'pending',
            'description' => 'Request to access personal data',
        ]);

        $this->assertEquals($user->id, $gdprRequest->user_id);
        $this->assertEquals('data_access', $gdprRequest->type);
        $this->assertEquals('pending', $gdprRequest->status);
    }

    /** @test */
    public function it_can_process_gdpr_request_workflow(): void
    {
        // Arrange
        $user = User::factory()->create();
        $gdprRequest = GdprRequest::factory()->create([
            'user_id' => $user->id,
            'type' => 'data_deletion',
            'status' => 'pending',
        ]);

        // Act - Pending to Under Review
        $gdprRequest->update(['status' => 'under_review']);

        // Assert
        $this->assertEquals('under_review', $gdprRequest->fresh()->status);

        // Act - Under Review to Approved
        $gdprRequest->update(['status' => 'approved']);

        // Assert
        $this->assertEquals('approved', $gdprRequest->fresh()->status);

        // Act - Approved to Completed
        $gdprRequest->update(['status' => 'completed']);

        // Assert
        $this->assertEquals('completed', $gdprRequest->fresh()->status);
    }

    /** @test */
    public function it_can_manage_gdpr_consents(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $gdprConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'marketing',
            'consent_given' => true,
            'consent_date' => now(),
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Test Browser',
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $gdprConsent->id,
            'user_id' => $user->id,
            'consent_type' => 'marketing',
            'consent_given' => true,
        ]);

        $this->assertEquals($user->id, $gdprConsent->user_id);
        $this->assertEquals('marketing', $gdprConsent->consent_type);
        $this->assertTrue($gdprConsent->consent_given);
        $this->assertEquals('192.168.1.1', $gdprConsent->ip_address);
    }

    /** @test */
    public function it_can_track_consent_changes(): void
    {
        // Arrange
        $user = User::factory()->create();
        $gdprConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'marketing',
            'consent_given' => true,
            'consent_date' => now()->subDays(30),
        ]);

        // Act - Withdraw consent
        $gdprConsent->update([
            'consent_given' => false,
            'consent_withdrawn_at' => now(),
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $gdprConsent->id,
            'consent_given' => false,
        ]);

        $this->assertFalse($gdprConsent->fresh()->consent_given);
        $this->assertNotNull($gdprConsent->fresh()->consent_withdrawn_at);
    }

    /** @test */
    public function it_can_manage_data_exports(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $dataExport = GdprDataExport::factory()->create([
            'user_id' => $user->id,
            'export_type' => 'personal_data',
            'status' => 'processing',
            'file_path' => '/exports/user_data_123.json',
            'expires_at' => now()->addDays(30),
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_data_exports', [
            'id' => $dataExport->id,
            'user_id' => $user->id,
            'export_type' => 'personal_data',
            'status' => 'processing',
        ]);

        $this->assertEquals($user->id, $dataExport->user_id);
        $this->assertEquals('personal_data', $dataExport->export_type);
        $this->assertEquals('processing', $dataExport->status);
        $this->assertEquals('/exports/user_data_123.json', $dataExport->file_path);
    }

    /** @test */
    public function it_can_process_data_export_workflow(): void
    {
        // Arrange
        $user = User::factory()->create();
        $dataExport = GdprDataExport::factory()->create([
            'user_id' => $user->id,
            'export_type' => 'personal_data',
            'status' => 'requested',
        ]);

        // Act - Requested to Processing
        $dataExport->update(['status' => 'processing']);

        // Assert
        $this->assertEquals('processing', $dataExport->fresh()->status);

        // Act - Processing to Completed
        $dataExport->update([
            'status' => 'completed',
            'completed_at' => now(),
            'file_size' => 1024,
        ]);

        // Assert
        $this->assertEquals('completed', $dataExport->fresh()->status);
        $this->assertNotNull($dataExport->fresh()->completed_at);
        $this->assertEquals(1024, $dataExport->fresh()->file_size);
    }

    /** @test */
    public function it_can_manage_data_deletions(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $dataDeletion = GdprDataDeletion::factory()->create([
            'user_id' => $user->id,
            'deletion_type' => 'complete',
            'status' => 'scheduled',
            'scheduled_at' => now()->addDays(7),
            'reason' => 'User requested complete data deletion',
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_data_deletions', [
            'id' => $dataDeletion->id,
            'user_id' => $user->id,
            'deletion_type' => 'complete',
            'status' => 'scheduled',
        ]);

        $this->assertEquals($user->id, $dataDeletion->user_id);
        $this->assertEquals('complete', $dataDeletion->deletion_type);
        $this->assertEquals('scheduled', $dataDeletion->status);
        $this->assertEquals('User requested complete data deletion', $dataDeletion->reason);
    }

    /** @test */
    public function it_can_execute_data_deletion_workflow(): void
    {
        // Arrange
        $user = User::factory()->create();
        $dataDeletion = GdprDataDeletion::factory()->create([
            'user_id' => $user->id,
            'deletion_type' => 'complete',
            'status' => 'scheduled',
            'scheduled_at' => now(),
        ]);

        // Act - Scheduled to Processing
        $dataDeletion->update(['status' => 'processing']);

        // Assert
        $this->assertEquals('processing', $dataDeletion->fresh()->status);

        // Act - Processing to Completed
        $dataDeletion->update([
            'status' => 'completed',
            'completed_at' => now(),
            'deleted_records_count' => 150,
        ]);

        // Assert
        $this->assertEquals('completed', $dataDeletion->fresh()->status);
        $this->assertNotNull($dataDeletion->fresh()->completed_at);
        $this->assertEquals(150, $dataDeletion->fresh()->deleted_records_count);
    }

    /** @test */
    public function it_can_validate_gdpr_request_types(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act & Assert - Valid request types
        $validTypes = ['data_access', 'data_rectification', 'data_deletion', 'data_portability'];

        foreach ($validTypes as $type) {
            $gdprRequest = GdprRequest::factory()->create([
                'user_id' => $user->id,
                'type' => $type,
                'status' => 'pending',
            ]);

            $this->assertEquals($type, $gdprRequest->type);
            $this->assertDatabaseHas('gdpr_requests', [
                'id' => $gdprRequest->id,
                'type' => $type,
            ]);
        }
    }

    /** @test */
    public function it_can_manage_consent_categories(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $marketingConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'marketing',
            'consent_given' => true,
        ]);

        $analyticsConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'analytics',
            'consent_given' => false,
        ]);

        $necessaryConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'necessary',
            'consent_given' => true,
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $marketingConsent->id,
            'consent_type' => 'marketing',
        ]);

        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $analyticsConsent->id,
            'consent_type' => 'analytics',
        ]);

        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $necessaryConsent->id,
            'consent_type' => 'necessary',
        ]);

        $this->assertTrue($marketingConsent->consent_given);
        $this->assertFalse($analyticsConsent->consent_given);
        $this->assertTrue($necessaryConsent->consent_given);
    }

    /** @test */
    public function it_can_track_gdpr_audit_trail(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act - Create multiple requests
        GdprRequest::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
                'type' => 'data_access',
            ]);

        GdprRequest::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
                'type' => 'data_deletion',
            ]);

        // Act - Create consents
        GdprConsent::factory()
            ->count(4)
            ->create([
                'user_id' => $user->id,
                'consent_given' => true,
            ]);

        // Assert
        $totalRequests = GdprRequest::where('user_id', $user->id)->count();
        $accessRequests = GdprRequest::where('user_id', $user->id)->where('type', 'data_access')->count();
        $deletionRequests = GdprRequest::where('user_id', $user->id)->where('type', 'data_deletion')->count();
        $totalConsents = GdprConsent::where('user_id', $user->id)->count();

        $this->assertEquals(5, $totalRequests);
        $this->assertEquals(3, $accessRequests);
        $this->assertEquals(2, $deletionRequests);
        $this->assertEquals(4, $totalConsents);
    }

    /** @test */
    public function it_can_manage_data_retention_policies(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $dataExport = GdprDataExport::factory()->create([
            'user_id' => $user->id,
            'export_type' => 'personal_data',
            'status' => 'completed',
            'completed_at' => now()->subDays(25),
            'expires_at' => now()->addDays(5),
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_data_exports', [
            'id' => $dataExport->id,
            'status' => 'completed',
        ]);

        $this->assertEquals('completed', $dataExport->status);
        $this->assertTrue($dataExport->expires_at->isFuture());
        $this->assertTrue($dataExport->expires_at->diffInDays(now()) <= 30);
    }

    /** @test */
    public function it_can_handle_urgent_deletion_requests(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $urgentDeletion = GdprDataDeletion::factory()->create([
            'user_id' => $user->id,
            'deletion_type' => 'urgent',
            'status' => 'pending',
            'priority' => 'high',
            'reason' => 'Legal requirement for immediate deletion',
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_data_deletions', [
            'id' => $urgentDeletion->id,
            'deletion_type' => 'urgent',
            'priority' => 'high',
        ]);

        $this->assertEquals('urgent', $urgentDeletion->deletion_type);
        $this->assertEquals('high', $urgentDeletion->priority);
        $this->assertEquals('Legal requirement for immediate deletion', $urgentDeletion->reason);
    }

    /** @test */
    public function it_can_validate_consent_legal_basis(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $explicitConsent = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'marketing',
            'consent_given' => true,
            'legal_basis' => 'explicit_consent',
            'consent_date' => now(),
        ]);

        $legitimateInterest = GdprConsent::factory()->create([
            'user_id' => $user->id,
            'consent_type' => 'necessary',
            'consent_given' => true,
            'legal_basis' => 'legitimate_interest',
            'consent_date' => now(),
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $explicitConsent->id,
            'legal_basis' => 'explicit_consent',
        ]);

        $this->assertDatabaseHas('gdpr_consents', [
            'id' => $legitimateInterest->id,
            'legal_basis' => 'legitimate_interest',
        ]);

        $this->assertEquals('explicit_consent', $explicitConsent->legal_basis);
        $this->assertEquals('legitimate_interest', $legitimateInterest->legal_basis);
    }

    /** @test */
    public function it_can_manage_data_processing_activities(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $gdprRequest = GdprRequest::factory()->create([
            'user_id' => $user->id,
            'type' => 'data_access',
            'status' => 'processing',
            'processing_started_at' => now(),
            'estimated_completion' => now()->addDays(3),
        ]);

        // Assert
        $this->assertDatabaseHas('gdpr_requests', [
            'id' => $gdprRequest->id,
            'status' => 'processing',
        ]);

        $this->assertEquals('processing', $gdprRequest->status);
        $this->assertNotNull($gdprRequest->processing_started_at);
        $this->assertNotNull($gdprRequest->estimated_completion);
        $this->assertTrue($gdprRequest->estimated_completion->isFuture());
    }
}
