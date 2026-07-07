<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Modules\Gdpr\Database\Factories\ConsentFactory;
use Modules\Gdpr\Database\Factories\TreatmentFactory;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('GDPR Consent Business Logic', function () {
    beforeEach(function (): void {
        /* @var \Modules\Gdpr\Tests\TestCase $this */
        gdprAssertDatabaseAvailable();
    });

    it('records consent with required metadata', function () {
        $user = UserFactory::new()->createOne();
        $treatment = TreatmentFactory::new()->createOne([
            'name' => 'marketing_emails',
            'description' => 'Marketing emails',
            'weight' => 1,
            'active' => true,
            'required' => false,
        ]);

        $consent = ConsentFactory::new()->createOne([
            'subject_id' => $user->id,
            'treatment_id' => $treatment->id,
            'user_id' => $user->id,
            'user_type' => $user::class,
            'type' => 'marketing_emails',
            'accepted_at' => now()->toDateTimeString(),
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
        ]);

        Assert::assertInstanceOf(Consent::class, $consent);
        Assert::assertSame($user->id, $consent->subject_id);
        Assert::assertSame('marketing_emails', $consent->type);
        Assert::assertSame('192.168.1.1', $consent->ip_address);
    });

    it('links consent to treatment', function () {
        $treatment = TreatmentFactory::new()->createOne([
            'name' => 'analytics',
            'description' => 'Analytics processing',
            'weight' => 5,
            'active' => true,
            'required' => true,
        ]);

        $consent = ConsentFactory::new()->createOne([
            'treatment_id' => $treatment->id,
            'type' => 'analytics',
        ]);

        Assert::assertSame($treatment->id, $consent->treatment_id);
        Assert::assertInstanceOf(Treatment::class, $consent->treatment);
    });

    it('validates fillable consent fields', function () {
        $consent = new Consent();
        $fillable = $consent->getFillable();

        assertFillableContains([
            'subject_id',
            'treatment_id',
            'user_id',
            'user_type',
            'type',
            'accepted_at',
            'ip_address',
            'user_agent',
        ], $fillable);
    });
});
