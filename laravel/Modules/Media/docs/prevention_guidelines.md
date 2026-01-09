# Linee Guida Prevenzione Problemi - Modulo Media

## 🚨 Problemi Critici Risolti in S3Test.php

### 1. **Violazioni Architetturali - MAI PIÙ**

#### ❌ **Problema Risolto**
```php
// VIETATO - Import diretti tra moduli
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Emails\EmailDataEmail;

// VIETATO - Accoppiamento stretto
$emailData = new EmailData($data);
$email = new EmailDataEmail($emailData);
```

#### ✅ **Soluzione Implementata**
```php
// CORRETTO - Logging semplice per test
Log::info('S3 Test completato', [
    'bucket' => $bucket,
    'result' => $result
]);

// CORRETTO - Notifiche Filament native
Notification::make()
    ->title(__('media::s3test.notifications.success.title'))
    ->body(__('media::s3test.notifications.success.body'))
    ->success()
    ->send();
```

### 2. **Tipizzazione PHPStan - SEMPRE RIGOROSA**

#### ❌ **Problema Risolto**
```php
// VIETATO - Uso di mixed
public function testCredentials(): mixed
{
    return $this->s3Client->listBuckets();
}

// VIETATO - Mancanza type hints
public function getTestResults()
{
    return $this->results;
}
```

#### ✅ **Soluzione Implementata**
```php
// CORRETTO - Tipi specifici
public function testCredentials(): array
{
    try {
        $result = $this->s3Client->listBuckets();
        return $result->toArray();
    } catch (AwsException $e) {
        Log::error('AWS Credentials test failed', [
            'error' => $e->getMessage(),
            'code' => $e->getAwsErrorCode()
        ]);
        return [];
    }
}

// CORRETTO - Type hints completi
/**
 * @return array<string, mixed>
 */
public function getTestResults(): array
{
    return $this->results;
}
```

### 3. **Traduzioni - SEMPRE COMPLETE**

#### ❌ **Problema Risolto**
```php
// VIETATO - Stringhe hardcoded
$this->label('Test Credenziali AWS')
    ->tooltip('Verifica le credenziali AWS');

// VIETATO - Struttura piatta
'label' => 'Test Credenziali AWS',
```

#### ✅ **Soluzione Implementata**
```php
// CORRETTO - Traduzioni da file
$this->label(__('media::s3test.actions.testCredentials.label'))
    ->tooltip(__('media::s3test.actions.testCredentials.tooltip'));

// CORRETTO - Struttura espansa
'actions' => [
    'testCredentials' => [
        'label' => 'Test Credenziali AWS',
        'tooltip' => 'Verifica le credenziali AWS configurate',
        'success' => 'Credenziali AWS valide',
        'error' => 'Errore nelle credenziali AWS',
    ],
],
```

## 🔧 **Regole di Prevenzione**

### 1. **Architettura Modulare**

#### ✅ **Regole da Seguire**
- **MAI** importare classi da altri moduli direttamente
- **SEMPRE** usare interfacce e contratti per comunicazione tra moduli
- **SEMPRE** mantenere i moduli disaccoppiati
- **SEMPRE** usare eventi per comunicazione asincrona

#### 📋 **Checklist Architettura**
- [ ] Nessun import diretto tra moduli
- [ ] Uso di interfacce per comunicazione
- [ ] Eventi per comunicazione asincrona
- [ ] Logging appropriato per debug
- [ ] Gestione errori robusta

### 2. **Tipizzazione PHPStan**

#### ✅ **Regole da Seguire**
- **SEMPRE** usare `declare(strict_types=1);`
- **MAI** usare `mixed` se non strettamente necessario
- **SEMPRE** specificare tipi di ritorno espliciti
- **SEMPRE** usare type hints per parametri
- **SEMPRE** documentare con PHPDoc

#### 📋 **Checklist Tipizzazione**
- [ ] `declare(strict_types=1);` presente
- [ ] Nessun `mixed` non necessario
- [ ] Tipi di ritorno espliciti
- [ ] Type hints per parametri
- [ ] PHPDoc completo
- [ ] PHPStan Level 9+ passa

### 3. **Sistema Traduzioni**

#### ✅ **Regole da Seguire**
- **MAI** usare stringhe hardcoded
- **SEMPRE** usare file di traduzione
- **SEMPRE** struttura espansa per campi e azioni
- **SEMPRE** traduzioni in IT/EN/DE
- **SEMPRE** helper_text diverso da placeholder

#### 📋 **Checklist Traduzioni**
- [ ] Nessuna stringa hardcoded
- [ ] File traduzione creati
- [ ] Struttura espansa completa
- [ ] Traduzioni IT/EN/DE
- [ ] Helper_text appropriato
- [ ] Sintassi `[]` moderna

### 4. **Gestione Errori**

#### ✅ **Regole da Seguire**
- **SEMPRE** usare try-catch appropriati
- **SEMPRE** loggare errori con contesto
- **SEMPRE** gestire casi edge
- **SEMPRE** notifiche utente appropriate
- **SEMPRE** fallback graceful

#### 📋 **Checklist Errori**
- [ ] Try-catch per operazioni critiche
- [ ] Logging con contesto completo
- [ ] Gestione casi edge
- [ ] Notifiche utente
- [ ] Fallback graceful
- [ ] Test error scenarios

## 🧪 **Testing di Prevenzione**

### 1. **Test Architettura**
```php
public function test_no_direct_module_imports(): void
{
    $file = file_get_contents(__DIR__ . '/../../app/Filament/Clusters/Test/Pages/S3Test.php');

    // Verifica che non ci siano import diretti tra moduli
    $this->assertStringNotContainsString('use Modules\\Notify', $file);
    $this->assertStringNotContainsString('use Modules\\User', $file);
    $this->assertStringNotContainsString('use Modules\\Performance', $file);
}
```

### 2. **Test Tipizzazione**
```php
public function test_phpstan_compliance(): void
{
    $output = shell_exec('./vendor/bin/phpstan analyse Modules/Media --level=9 --no-progress');

    $this->assertStringNotContainsString('ERROR', $output);
    $this->assertStringNotContainsString('mixed', $output);
}
```

### 3. **Test Traduzioni**
```php
public function test_translation_completeness(): void
{
    $languages = ['it', 'en', 'de'];
    $translationFiles = ['s3test.php'];

    foreach ($languages as $lang) {
        foreach ($translationFiles as $file) {
            $path = "Modules/Media/lang/{$lang}/{$file}";
            $this->assertFileExists($path);

            $translations = require $path;
            $this->assertIsArray($translations);
            $this->assertNotEmpty($translations);
        }
    }
}
```

## 📚 **Documentazione Prevenzione**

### 1. **Template per Nuovi File**
```php
<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Illuminate\Support\Facades\Log;

class NewTestPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'media::filament.pages.new-test-page';

    /**
     * Test method with proper typing.
     *
     * @return array<string, mixed>
     */
    public function performTest(): array
    {
        try {
            // Test logic here
            $result = $this->executeTest();

            Log::info('Test completed successfully', [
                'test' => static::class,
                'result' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Test failed', [
                'test' => static::class,
                'error' => $e->getMessage()
            ]);

            return ['error' => $e->getMessage()];
        }
    }
}
```

### 2. **Template Traduzioni**
```php
<?php

declare(strict_types=1);

return [
    'actions' => [
        'testAction' => [
            'label' => 'Test Action',
            'tooltip' => 'Perform test action',
            'success' => 'Test completed successfully',
            'error' => 'Test failed',
        ],
    ],
    'fields' => [
        'testField' => [
            'label' => 'Test Field',
            'placeholder' => 'Enter test value',
            'help' => 'This field is used for testing',
        ],
    ],
    'notifications' => [
        'success' => [
            'title' => 'Success',
            'body' => 'Operation completed successfully',
        ],
        'error' => [
            'title' => 'Error',
            'body' => 'Operation failed',
        ],
    ],
];
```

## 🚨 **Controlli Automatici**

### 1. **Pre-commit Hook**
```bash
#!/bin/bash
# .git/hooks/pre-commit

# Controllo PHPStan
./vendor/bin/phpstan analyse Modules/Media --level=9 --no-progress

# Controllo traduzioni
php artisan translation:check --module=Media

# Controllo import diretti
grep -r "use Modules\\" Modules/Media/app/ --include="*.php" | grep -v "use Modules\\Media" && exit 1
```

### 2. **CI/CD Pipeline**
```yaml
# .github/workflows/media-checks.yml
name: Media Module Checks

on: [push, pull_request]

jobs:
  media-checks:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'

    - name: Install dependencies
      run: composer install

    - name: PHPStan check
      run: ./vendor/bin/phpstan analyse Modules/Media --level=9

    - name: Translation check
      run: php artisan translation:check --module=Media

    - name: Architecture check
      run: |
        if grep -r "use Modules\\" Modules/Media/app/ --include="*.php" | grep -v "use Modules\\Media"; then
          echo "Direct module imports detected!"
          exit 1
        fi
```

## 📊 **Metriche Prevenzione**

### 1. **Indicatori di Qualità**
- **Architettura**: 0 import diretti tra moduli
- **Tipizzazione**: 100% PHPStan Level 9 compliance
- **Traduzioni**: 100% file traduzione completi
- **Errori**: 0 errori runtime critici
- **Performance**: < 2s per operazioni test

### 2. **Monitoraggio Continuo**
- **Daily Checks**: Controlli automatici giornalieri
- **Weekly Reviews**: Revisioni settimanali codice
- **Monthly Audits**: Audit mensili architettura
- **Quarterly Updates**: Aggiornamenti trimestrali

## 🔗 **Collegamenti**

- [Correzioni S3Test.php](s3test_corrections.md)
- [PHPStan Fixes](phpstan_level10_fixes.md)
- [Translation Standards](translations.md)
- [Architecture Guidelines](../docs/architecture.md)

---

**🔄 Ultimo aggiornamento**: 27 Gennaio 2025
**📦 Versione**: 3.1.0
**🎯 Obiettivo**: Prevenzione completa problemi futuri
**✅ Status**: Linee guida implementate e testate
