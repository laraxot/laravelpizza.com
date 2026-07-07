# Lang Module - Testing Guidelines

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration:
```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=<nome progetto>_data_test
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. Translation Management Tests

#### Core Translation Operations
```php
<?php

declare(strict_types=1);

use Modules\Lang\Models\Translation;
use Modules\Lang\Models\Language;
use Modules\Lang\Models\TranslationKey;

describe('Translation Management Business Logic', function () {
    it('creates and manages translation keys hierarchically', function () {
        $key = TranslationKey::create([
            'key' => 'medical.procedures.dental_cleaning',
            'context' => 'medical_procedure',
            'description' => 'Dental cleaning procedure description',
            'is_medical_content' => true,
        ]);

        expect($key)
            ->toBeInstanceOf(TranslationKey::class)
            ->and($key->key)->toBe('medical.procedures.dental_cleaning')
            ->and($key->is_medical_content)->toBeTrue();
    });

    it('stores and retrieves translations for multiple languages', function () {
        $language_en = Language::factory()->create(['code' => 'en', 'name' => 'English']);
        $language_it = Language::factory()->create(['code' => 'it', 'name' => 'Italian']);

        $key = TranslationKey::factory()->create([
            'key' => 'appointment.confirmation.title'
        ]);

        Translation::create([
            'translation_key_id' => $key->id,
            'language_id' => $language_en->id,
            'value' => 'Appointment Confirmation',
            'is_approved' => true,
        ]);

        Translation::create([
            'translation_key_id' => $key->id,
            'language_id' => $language_it->id,
            'value' => 'Conferma Appuntamento',
            'is_approved' => true,
        ]);

        $englishTranslation = Translation::getTranslation('appointment.confirmation.title', 'en');
        $italianTranslation = Translation::getTranslation('appointment.confirmation.title', 'it');

        expect($englishTranslation)->toBe('Appointment Confirmation')
            ->and($italianTranslation)->toBe('Conferma Appuntamento');
    });

    it('handles translation approval workflow', function () {
        $translation = Translation::factory()->create([
            'value' => 'Medical procedure description',
            'is_approved' => false,
            'requires_medical_review' => true,
        ]);

        expect($translation->is_approved)->toBeFalse()
            ->and($translation->canBePublished())->toBeFalse();

        $translation->approve('medical_reviewer_123', 'Clinically accurate translation');

        expect($translation->fresh()->is_approved)->toBeTrue()
            ->and($translation->fresh()->approved_by)->toBe('medical_reviewer_123')
            ->and($translation->fresh()->canBePublished())->toBeTrue();
    });

    it('implements fallback mechanism for missing translations', function () {
        $key = TranslationKey::factory()->create(['key' => 'test.message']);

        // Only English translation exists
        Translation::factory()->create([
            'translation_key_id' => $key->id,
            'language_id' => Language::factory()->create(['code' => 'en'])->id,
            'value' => 'English message',
            'is_approved' => true,
        ]);

        // Request Italian translation (doesn't exist)
        $translation = Translation::getTranslation('test.message', 'it', ['fallback' => true]);

        expect($translation)->toBe('English message'); // Falls back to English
    });
});
```

### 2. Language Preference Tests

```php
describe('Language Preference Business Logic', function () {
    it('sets and retrieves user language preferences', function () {
        $user = User::factory()->create();

        $user->setLanguagePreference('it-IT', [
            'medical_terms' => true,
            'notifications' => true,
            'billing' => false,
        ]);

        $preference = $user->getLanguagePreference();

        expect($preference->language_code)->toBe('it-IT')
            ->and($preference->preferences['medical_terms'])->toBeTrue()
            ->and($preference->preferences['billing'])->toBeFalse();
    });

    it('cascades language preferences from user to patient', function () {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id]);

        $user->setLanguagePreference('es-ES');

        $patientLanguage = $patient->getEffectiveLanguage();

        expect($patientLanguage)->toBe('es-ES');
    });

    it('detects language from browser and geographic data', function () {
        $detector = new LanguageDetector();

        // Mock browser language
        $browserLanguage = $detector->detectFromBrowser(['it-IT', 'en-US']);
        expect($browserLanguage)->toBe('it-IT');

        // Mock geographic detection
        $geoLanguage = $detector->detectFromLocation('Italy', 'Rome');
        expect($geoLanguage)->toBe('it-IT');
    });

    it('handles emergency language override', function () {
        $patient = Patient::factory()->create();
        $patient->setLanguagePreference('zh-CN');

        // Emergency situation - should use practice default
        $emergencyLanguage = $patient->getLanguageForEmergency();

        expect($emergencyLanguage)->toBe(config('app.locale')); // Practice default
    });
});
```

### 3. Healthcare Content Tests

```php
describe('Healthcare Content Localization', function () {
    it('localizes medical procedure descriptions', function () {
        $procedure = MedicalProcedure::factory()->create([
            'name' => 'Dental Cleaning',
            'description' => 'Professional dental cleaning procedure',
        ]);

        $procedure->setTranslation('name', 'it', 'Pulizia Dentale');
        $procedure->setTranslation('description', 'it', 'Procedura di pulizia dentale professionale');

        expect($procedure->getTranslation('name', 'it'))->toBe('Pulizia Dentale')
            ->and($procedure->getTranslation('description', 'it'))->toBe('Procedura di pulizia dentale professionale');
    });

    it('validates medical terminology translations', function () {
        $validator = new MedicalTerminologyValidator();

        $validTranslation = $validator->validate('hypertension', 'ipertensione', 'it');
        $invalidTranslation = $validator->validate('hypertension', 'wrong_term', 'it');

        expect($validTranslation->isValid())->toBeTrue()
            ->and($invalidTranslation->isValid())->toBeFalse()
            ->and($invalidTranslation->getErrors())->toContain('Invalid medical terminology');
    });

    it('generates localized patient consent forms', function () {
        $patient = Patient::factory()->create();
        $patient->setLanguagePreference('fr-FR');

        $consentForm = ConsentFormGenerator::generate('dental_procedure', $patient);

        expect($consentForm->language)->toBe('fr-FR')
            ->and($consentForm->content)->toContain('consentement')
            ->and($consentForm->isLegallyValid())->toBeTrue();
    });

    it('localizes appointment notifications', function () {
        $patient = Patient::factory()->create();
        $patient->setLanguagePreference('de-DE');

        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);

        $notification = AppointmentNotification::create($appointment);

        expect($notification->language)->toBe('de-DE')
            ->and($notification->subject)->toContain('Termin')
            ->and($notification->body)->toContain('Zahnarzt');
    });
});
```

### 4. Integration Tests

```php
describe('Lang Integration Tests', function () {
    it('integrates with CMS for multilingual content', function () {
        $page = CmsPage::factory()->create(['title' => 'About Us']);

        $page->setTranslation('title', 'it', 'Chi Siamo');
        $page->setTranslation('content', 'it', 'Contenuto della pagina in italiano');

        app()->setLocale('it');

        expect($page->title)->toBe('Chi Siamo')
            ->and($page->content)->toContain('italiano');
    });

    it('integrates with notification system for multilingual messages', function () {
        $patient = Patient::factory()->create();
        $patient->setLanguagePreference('es-ES');

        $notification = new AppointmentReminderNotification($patient);

        expect($notification->getLanguage())->toBe('es-ES')
            ->and($notification->getSubject())->toContain('Recordatorio')
            ->and($notification->getBody())->toContain('cita');
    });

    it('handles database content localization', function () {
        $service = HealthcareService::factory()->create([
            'name' => 'General Consultation',
            'description' => 'General medical consultation',
        ]);

        $service->setTranslations([
            'it' => [
                'name' => 'Consulto Generale',
                'description' => 'Consulto medico generale',
            ],
            'fr' => [
                'name' => 'Consultation Générale',
                'description' => 'Consultation médicale générale',
            ],
        ]);

        app()->setLocale('it');
        expect($service->name)->toBe('Consulto Generale');

        app()->setLocale('fr');
        expect($service->name)->toBe('Consultation Générale');
    });

    it('generates multilingual PDF documents', function () {
        $patient = Patient::factory()->create();
        $patient->setLanguagePreference('pt-BR');

        $invoice = Invoice::factory()->create(['patient_id' => $patient->id]);

        $pdf = InvoicePdfGenerator::generate($invoice);

        expect($pdf->getLanguage())->toBe('pt-BR')
            ->and($pdf->getContent())->toContain('Fatura')
            ->and($pdf->isValid())->toBeTrue();
    });
});
```

### 5. Performance Tests

```php
describe('Lang Performance Tests', function () {
    it('caches translations for improved performance', function () {
        // Create many translations
        $keys = TranslationKey::factory()->count(100)->create();
        $languages = Language::factory()->count(5)->create();

        foreach ($keys as $key) {
            foreach ($languages as $language) {
                Translation::factory()->create([
                    'translation_key_id' => $key->id,
                    'language_id' => $language->id,
                ]);
            }
        }

        $startTime = microtime(true);

        // Retrieve translations (should be cached after first load)
        for ($i = 0; $i < 50; $i++) {
            Translation::getTranslation($keys->random()->key, $languages->random()->code);
        }

        $duration = microtime(true) - $startTime;

        expect($duration)->toBeLessThan(1.0); // Should complete in under 1 second
    });

    it('handles large translation datasets efficiently', function () {
        $startTime = microtime(true);

        // Create large dataset
        TranslationKey::factory()->count(1000)->create();

        $creationTime = microtime(true) - $startTime;

        expect($creationTime)->toBeLessThan(5.0); // Should complete in under 5 seconds
    });

    it('optimizes database queries for translation retrieval', function () {
        DB::enableQueryLog();

        $keys = TranslationKey::factory()->count(10)->create();

        // Retrieve multiple translations
        $translations = Translation::getMultipleTranslations(
            $keys->pluck('key')->toArray(),
            'en'
        );

        $queries = DB::getQueryLog();

        expect(count($queries))->toBeLessThanOrEqual(3); // Should use efficient queries
        expect($translations)->toHaveCount(10);
    });
});
```

## Quality Standards

### Test Requirements

- All tests use `declare(strict_types=1);`
- Descriptive test names explaining language scenarios
- Complete setup and teardown for language state
- Meaningful assertions covering translation accuracy
- Performance benchmarks for translation operations

### Business Logic Focus

- Translation accuracy and consistency
- Language preference management
- Healthcare content localization
- Multi-language workflow integration
- Performance optimization

### Healthcare Compliance

- Medical terminology accuracy
- Legal document translation validation
- Patient communication clarity
- Accessibility compliance testing
- Audit trail verification

---

**Last Updated**: 2025-08-28
**Testing Framework**: Pest
**Environment**: .env.testing
