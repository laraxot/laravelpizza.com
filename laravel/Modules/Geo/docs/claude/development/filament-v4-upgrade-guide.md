# Guida Upgrade Filament v4 - Laraxot PTVX

## 📋 Panoramica Upgrade

Questa guida documenta l'upgrade a **Filament v4** nel progetto Laraxot PTVX, inclusi tutti i cambiamenti breaking, nuove funzionalità e procedure di migrazione.

### 🎯 Status Upgrade
- **Data Inizio**: Dicembre 2025
- **Versione Target**: Filament v4.x
- **Stato**: In Corso - Applicazione Incrementale
- **Approccio**: Migrazione graduale con testing continuo

---

## 🚀 Nuove Funzionalità Filament v4

### Performance Migliorate
- **Rendering 2-3x più veloce** per tabelle grandi
- **Riduzione richieste network** con `hiddenJs()` e `afterStateUpdatedJs()`
- **Ottimizzazioni Blade templates** e classi CSS Tailwind

### Tailwind CSS v4
- **Sistema colori `oklch`** più vividi e accurati
- **Configurazione riprogettata** per maggiore flessibilità
- **Build più veloci** e migliori performance

### Sicurezza Avanzata
- **MFA integrato** (Multi-Factor Authentication)
- **File visibility private** per default su dischi non-local
- **Temporary signed URLs** per accesso sicuro ai file

### Nuovi Componenti
- **TipTap Rich Editor** con blocchi custom e merge tags
- **Slider** per input numerici
- **Code Editor** con syntax highlighting
- **Table Repeater** per dati tabulari complessi

### Funzionalità Avanzate
- **Risorse annidate** con breadcrumbs e URL gerarchici
- **Tabelle con dati custom** (non solo Eloquent)
- **Bulk actions migliorate** con autorizzazioni per record individuali
- **Partial rendering** per ridurre rendering server-side

---

## ⚠️ Breaking Changes Critici

### 1. File Visibility (HIGH IMPACT)
**Prima di Filament v4:**
```php
// File pubblici per default su tutti i dischi
FileUpload::make('file')->disk('s3') // → public
```

**Dopo Filament v4:**
```php
// File privati per default su dischi non-local (s3, etc.)
FileUpload::make('file')->disk('s3') // → private ❌

// Per mantenere comportamento v3:
FileUpload::configureUsing(fn (FileUpload $f) => $f->visibility('public'));
ImageColumn::configureUsing(fn (ImageColumn $c) => $c->visibility('public'));
ImageEntry::configureUsing(fn (ImageEntry $e) => $e->visibility('public'));
```

**Impatto su Laraxot:** Se usate S3 o dischi cloud, dovrete:
1. Configurare `visibility('public')` globalmente in un ServiceProvider
2. O generare signed URLs per accesso ai file privati

### 2. Directory Structure
**Nuova struttura di default:**
```
app/Filament/
├── Resources/           # ← Cambiato
│   ├── UserResource.php
│   └── UserResource/
│       └── Pages/
│           ├── ListUsers.php
│           └── CreateUser.php
└── Clusters/            # ← Nuovo
    └── AdminCluster.php
```

**Comando migrazione:**
```bash
php artisan filament:upgrade-directory-structure-to-v4 --dry-run
php artisan filament:upgrade-directory-structure-to-v4  # Produzione
```

### 3. Attributi PHP 8.3
**Sintassi cambiata:**
```php
// v3 - NON VALIDO
#[\Override]
public function getPages(): array { ... }

// v4 - CORRETTO
#[Override]
public function getPages(): array { ... }
```

**Impatto:** Tutti gli `#[\\Override]` devono essere cambiati in `#[Override]`

### 4. Import Componenti Schemas
**Nuovi namespace per componenti:**
```php
// Invece di Filament\Forms\Components
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Text;

// Per infolist/view pages
use Filament\Schemas\Components\TextEntry;
```

---

## 🔧 Procedure Upgrade Laraxot

### Fase 1: Preparazione
```bash
# 1. Backup completo
git commit -am "backup-pre-filament-v4"

# 2. Verifica requisiti
php --version        # ≥ 8.2
composer show laravel/framework  # ≥ 11.28
composer show tailwindcss  # ≥ 4.0

# 3. Installa script upgrade
composer require filament/upgrade:"^4.0" -W --dev

# 4. Leggi upgrade guide COMPLETA
# https://filamentphp.com/docs/4.x/upgrade-guide
```

### Fase 2: Script Automatico
```bash
# Esegui upgrade automatico
vendor/bin/filament-v4

# Risolvi conflitti mostrati
# Verifica cambiamenti con git diff
```

### Fase 3: Correzione Manuale

#### A. Attributi Override
```bash
# Trova tutti gli #[\\Override] errati
grep -r "#\[\\\\Override\]" --include="*.php" .

# Sostituisci con #[Override]
find . -name "*.php" -exec sed -i 's/#\[\\\\Override\]/#[Override]/g' {} \;
```

#### B. Import Componenti
```php
// In Resource classes - SOSTITUISCI
use Filament\Forms\Components\Section;  // ❌ OLD
use Filament\Forms\Components\Grid;     // ❌ OLD

// CON
use Filament\Schemas\Components\Section; // ✅ NEW
use Filament\Schemas\Components\Grid;    // ✅ NEW
use Filament\Forms\Components\Component; // ✅ NEW
use Filament\Resources\Pages\PageRegistration; // ✅ NEW
```

#### C. Type Hints Migliorati
```php
// Prima
public static function getFormSchema(): array

// Dopo (migliorato)
public static function getFormSchema(): array<string, Component>
```

### Fase 4: File Visibility
**Aggiungi in `AppServiceProvider::boot()`:**
```php
<?php
// app/Providers/AppServiceProvider.php
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Columns\ImageColumn;

public function boot(): void
{
    // Mantieni comportamento v3 per file visibility
    FileUpload::configureUsing(fn (FileUpload $f) => $f->visibility('public'));
    ImageColumn::configureUsing(fn (ImageColumn $c) => $c->visibility('public'));
    ImageEntry::configureUsing(fn (ImageEntry $e) => $e->visibility('public'));
}
```

### Fase 5: Testing e Validazione
```bash
# 1. Test PHPStan
./vendor/bin/phpstan analyse Modules/IndennitaResponsabilita

# 2. Test applicazione
php artisan test

# 3. Test manuale interfaccia
# - Verifica form funzionanti
# - Verifica tabelle responsive
# - Verifica file upload/download
# - Verifica azioni bulk
```

---

## 📚 Moduli Aggiornati

### ✅ IndennitaResponsabilita
- **Status**: Parzialmente aggiornato
- **File modificati**:
  - `ImportiCategoriaResource.php`
  - `LettFResource.php`
  - `LettIResource.php`
- **Cambiamenti applicati**:
  - ✅ Attributi `#[Override]` corretti
  - ✅ Import `Filament\Schemas\Components`
  - ✅ Type hints migliorati
  - ✅ Proprietà `$navigationIcon` formattate

### 🔄 PTV Module
- **Status**: Da aggiornare
- **File da controllare**:
  - `MyLogResource.php`
  - `ViewMyLog.php`
  - `ListMyLogs.php`

### ⏳ Altri Moduli
- **Status**: Non iniziato
- **Approccio**: Aggiornamento graduale per modulo

---

## 🐛 Problemi Risolti

### Override Attribute Syntax
```php
// ERRORE: #[\Override] - Syntax PHP < 8.3
#[\Override]
public function getPages(): array { ... }

// CORRETTO: #[Override] - Syntax PHP 8.3+
#[Override]
public function getPages(): array { ... }
```

### Import Namespace Schemas
```php
// ERRORE: Form components in Schema contexts
use Filament\Forms\Components\Section;

// CORRETTO: Schema components for forms
use Filament\Schemas\Components\Section;
```

### Type Hints Migliorati
```php
// MIGLIORATO: Generic types per array
public static function getFormSchema(): array<string, Component>
public static function getPages(): array<string, PageRegistration>
```

---

## 📋 Checklist Upgrade Completo

### Pre-Upgrade
- [x] Backup repository
- [x] Verifica requisiti (PHP 8.2+, Laravel 11.28+, Tailwind 4+)
- [x] Leggi upgrade guide completa
- [x] Setup script upgrade Filament

### Durante Upgrade
- [x] Esegui `vendor/bin/filament-v4`
- [x] Risolvi conflitti automatici
- [ ] **IN CORSO**: Correzione manuale override attributes
- [ ] **IN CORSO**: Aggiornamento import namespace
- [ ] **TODO**: Configurazione file visibility
- [ ] **TODO**: Migrazione directory structure (opzionale)

### Post-Upgrade
- [ ] Test PHPStan tutti moduli
- [ ] Test funzionalità complete
- [ ] Aggiornamento documentazione
- [ ] Training team su nuove funzionalità

---

## 🎯 Benefici Filament v4 in Laraxot

### Performance
- **2-3x più veloce** rendering tabelle grandi
- **Riduzione network requests** con metodi JS
- **Build Tailwind più veloci**

### Sicurezza
- **MFA integrato** per maggiore sicurezza
- **File privati** per default su cloud storage
- **Signed URLs** per accesso controllato

### UX/UI
- **Componenti più ricchi** (TipTap, sliders, etc.)
- **Risorse annidate** per strutture gerarchiche
- **Bulk actions avanzate** con feedback dettagliato

### Sviluppatore
- **Code generation migliorato**
- **Debugging facilitato** con partial rendering
- **API più consistente** e prevedibile

---

## 🔗 Risorse Utili

### Documentazione Ufficiale
- [Upgrade Guide Filament v4](https://filamentphp.com/docs/4.x/upgrade-guide)
- [What's New in Filament v4](https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4)
- [Installation Guide](https://filamentphp.com/docs/4.x/introduction/installation)

### Guide Community
- [Filament v3 to v4 Upgrade Tutorial](https://filamentexamples.com/tutorial/filament-v3-v4-upgrade)
- [Laravel Shift per Laravel Upgrade](https://laravelshift.com/)

### Troubleshooting
- [Discord Ufficiale Filament](https://discord.com/invite/filament)
- [GitHub Issues](https://github.com/filamentphp/filament/issues)

---

## 📞 Supporto e Contatti

Per problemi specifici dell'upgrade Filament v4 in Laraxot PTVX:

1. **Prima**: Consulta questa guida e upgrade guide ufficiale
2. **Poi**: Verifica repository GitHub per issues simili
3. **Infine**: Contatta team sviluppo per supporto specialistico

**Data ultimo aggiornamento**: Dicembre 2025
**Versione Filament target**: 4.x
**Compatibilità**: Laraxot PTVX, Laravel 11.28+, PHP 8.2+
