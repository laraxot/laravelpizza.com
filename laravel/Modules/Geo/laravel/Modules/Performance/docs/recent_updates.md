# Updates December 2025

## Refactoring Modules/Performance
This update focuses on strict adherence to the "Super Cow" methodology and "Laraxot" architecture, specifically targeting the `XotBase` inheritance and Internationalization (I18n) rules.

### 1. Inheritance Refactor
All Filament Pages and Resources that were extending base Filament classes directly have been refactored to extend their `XotBase` equivalents.

- **Resources**: `Filament\Resources\Resource` -> `Modules\Xot\Filament\Resources\XotBaseResource`
- **Pages**: `Filament\Resources\Pages\Page` -> `Modules\Xot\Filament\Resources\Pages\XotBasePage`
- **Create Records**: `Filament\Resources\Pages\CreateRecord` -> `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- **List Records**: `Filament\Resources\Pages\ListRecords` -> `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`

**Affected Files (Partial List):**
- `OrganizzativaMoney.php`
- `CreateCriteriMaggiorazione.php`
- `CreateIndividualePesi.php`
- ... and all other `CreateRecord` pages.

### 2. Translation Refactor (Hardcoded Labels)
Hardcoded `->label('...')` calls have been removed from Resources and Pages. New translation keys have been added to `Modules/Performance/lang/it/`.

**Affected Components:**
- `CriteriMaggiorazioneResource.php`
- `CriteriOptionResource.php`
- `ListIndividualePesis.php` (Custom Filter Schema)

**New Translation Files/Keys:**
- `lang/it/criteri_maggiorazione.php` (Merged new keys)
- `lang/it/criteri_option.php` (Merged new keys)
- `lang/it/individuale_pesi.php` ('value' field)

### 3. Verification
- **PHPStan**: Level 10 analysis performed on modified files.
- **Manual Check**: Verified imported classes and namespaces.
