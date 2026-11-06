<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Modules\Gdpr\Database\Factories\ConsentFactory;
use Modules\Gdpr\Database\Factories\TreatmentFactory;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

/**
 * Business logic del model Consent (tracciamento consensi GDPR).
 */
final class GdprConsentBusinessLogicTest extends TestCase
{
    public function test_declares_audit_and_lifecycle_fields_as_fillable(): void
    {
        $consent = new Consent;

        foreach ([
            'user_id',
            'user_type',
            'type',
            'accepted_at',
            'ip_address',
            'user_agent',
            'metadata',
            'revoked_at',
            'revoked_ip_address',
            'treatment_id',
        ] as $field) {
            Assert::assertContains($field, $consent->getFillable());
        }
    }

    public function test_casts_consent_metadata_and_timestamps(): void
    {
        $casts = (new Consent)->getCasts();

        Assert::assertSame('array', $casts['metadata'] ?? null);
        Assert::assertSame('datetime', $casts['accepted_at'] ?? null);
        Assert::assertSame('datetime', $casts['revoked_at'] ?? null);
    }

    public function test_associates_consent_with_a_treatment_definition(): void
    {
        $consent = new Consent;

        Assert::assertSame('treatment_id', $consent->treatment()->getForeignKeyName());
    }

    public function test_defaults_user_type_to_configured_user_class_when_missing(): void
    {
        $consent = (new ConsentFactory)->createOne([
            'user_type' => '',
        ]);

        Assert::assertSame(XotData::make()->getUserClass(), $consent->user_type);
    }

    public function test_persists_acceptance_metadata_from_factory_defaults(): void
    {
        $consent = (new ConsentFactory)->createOne([
            'type' => 'marketing_emails',
            'ip_address' => '192.168.1.1',
        ]);

        Assert::assertInstanceOf(Consent::class, $consent);
        Assert::assertSame('marketing_emails', $consent->type);
        Assert::assertSame('192.168.1.1', $consent->ip_address);
        Assert::assertNotNull($consent->accepted_at);
    }

    public function test_supports_revocation_via_revoked_at(): void
    {
        $consent = (new ConsentFactory)->createOne([
            'revoked_at' => null,
        ]);

        $consent->update(['revoked_at' => now()]);

        $fresh = $consent->fresh();
        Assert::assertInstanceOf(Consent::class, $fresh);
        Assert::assertNotNull($fresh->getAttributes()['revoked_at'] ?? null);
    }

    public function test_links_consent_rows_to_treatment_records(): void
    {
        $treatment = (new TreatmentFactory)->createOne();
        $consent = (new ConsentFactory)->createOne([
            'treatment_id' => $treatment->id,
        ]);

        Assert::assertInstanceOf(Treatment::class, $consent->treatment);
        Assert::assertSame($treatment->id, $consent->treatment_id);
    }
}
