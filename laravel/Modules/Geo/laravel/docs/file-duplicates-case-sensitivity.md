# File Duplicati - Case Sensitivity Issue

**Regola**: NON devono esistere file duplicati con nomi che differiscono solo per case (case-sensitive su filesystem Linux).

## Duplicati Trovati e Corretti

### Tenant Module
- `Modules/Tenant/tests/Unit/DomainTest.php` ✓ (CORRETTO)
- `Modules/Tenant/tests/Unit/domaintest.php.old` ✓ (rinominato)

### Gdpr Module
- `Modules/Gdpr/tests/Feature/ConflictResolutionTest.php` ✓ (CORRETTO)
- `Modules/Gdpr/tests/Feature/conflictresolutiontest.php.old` ✓ (rinominato)

### Media Module
- `Modules/Media/tests/Filament/Resources/MediaConvertResourceTest.php` ✓ (CORRETTO)
- `Modules/Media/tests/Filament/Resources/mediaconvertresourcetest.php.old` ✓ (rinominato)

### Xot Module
- `Modules/Xot/tests/Feature/FixStructureTest.php` ✓ (CORRETTO)
- `Modules/Xot/tests/Feature/FixStructureTest.pest.php` ✓ (OK - estensione diversa)
 - `Modules/Xot/tests/Pest.php` ✓ (CORRETTO - file di bootstrap Pest)
 - `Modules/Xot/tests/pest.php` ✗ (RIMOSSO - duplicato case-sensitive del file di bootstrap)
