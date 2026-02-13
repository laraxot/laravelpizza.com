# Riassunto Filosofia Laraxot - Gennaio 2026

**Autore**: Super Mucca AI
**Versione**: 1.0
**Status**: Documento Vivo

## 🎯 Panoramica

Questo documento sintetizza le conoscenze chiave acquisite sull'architettura Laraxot durante l'analisi approfondita del codicebase. È un riepilogo pratico delle regole, principi e best practices fondamentali.

## 🏛️ Filosofia Fondamentale (DRY + KISS + SOLID + Robust)

### Principi Guida
1. **DRY (Don't Repeat Yourself)**: Unica fonte di verità per ogni entità
2. **KISS (Keep It Simple, Stupid)**: Soluzioni semplici e dirette
3. **SOLID**: Principi di design orientato agli oggetti
4. **Robust**: Architettura resiliente e sicura

### Regole Ortodossia Laraxot
- **Nessuna estensione diretta di classi Filament** - SEMPRE usare XotBase*
- **Nessun `property_exists()` su modelli Eloquent** - usare `isset()` o `hasAttribute()`
- **Nessun controller per frontoffice** - usare Folio + Volt
- **Tutti i test in Pest** - mai PHPUnit class-based
- **Model estendono sempre BaseModel del modulo** - mai Model direttamente

## 🚨 Regole Critiche

### 1. Architettura Filament
```php
// ❌ MAI
class MyPage extends Filament\Resources\Pages\EditRecord

// ✅ SEMPRE
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
```

### 2. Model Inheritance
```php
// ❌ MAI
class MyModel extends Model

// ✅ SEMPRE
class MyModel extends BaseModel  // del modulo
```

### 3. Eloquent Magic Properties
```php
// ❌ MAI con Eloquent
if (property_exists($model, 'name')) { ... }

// ✅ SEMPRE con Eloquent
if (isset($model->name)) { ... }
// OPPURE
if ($model->hasAttribute('name')) { ... }
```

### 4. Traduzioni Filament
```php
// ❌ MAI hardcoded
TextInput::make('name')->label('Nome')

// ✅ SEMPRE da traduzioni
TextInput::make('name')  // label automatica da file di traduzione
```

## 🏗️ Architettura Moduli

### Struttura Gerarchica
```
 Illuminate\Database\Eloquent\Model
    ↓
 Modules\Xot\Models\XotBaseModel  (Core Framework)
    ↓
 Modules\{Module}\Models\BaseModel  (Per modulo)
    ↓
 Tuoi Modelli  (Business Logic)
```

### Migration Philosophy
- **Una sola `create_table` migration per ogni tabella**
- **Usare sempre `XotBaseMigration`**
- **Schema evolution con `tableUpdate()`, mai nuova `create_table`**

## 🧪 Testing con Pest

### Best Practices
```php
// Usare sempre TestCase di Xot
uses(\Modules\Xot\Tests\TestCase::class);

// Mockare XotData in beforeEach()
beforeEach(function (): void {
    mockXotData();
});

// Test strutturati correttamente
test('widget can be rendered', function () {
    Livewire::test(WidgetName::class)
        ->assertStatus(200);
});
```

## 🔧 Code Quality Standards

### PHPStan Level 10
- **Obiettivo**: Zero errori
- **Approccio**: Type safety massima
- **Pattern**: Strict types, type narrowing, union types

### PHPMD & Code Style
- **Pattern**: Rispettare regole di complessità
- **Formattazione**: Laravel Pint o PHP CS Fixer
- **Qualità**: Nessun code smell

## 🌐 Frontoffice: Folio + Volt

### Regole Architetturali
- **Nessun controller per pagine pubbliche**
- **Routing basato su file con Laravel Folio**
- **Componenti interattivi con Livewire Volt**
- **Layout con `x-layouts.app`, `x-layouts.guest`, ecc.**

## 📚 Documentazione

### Convenzioni Naming
- **File `.md`** solo in cartelle `docs` esistenti
- **Nomi minuscolo** con trattini, mai maiuscole (eccetto `README.md`)
- **Nessun `readme.md`** se esiste `README.md`
- **Link relativi** sempre, mai path assoluti

### Processo Documentazione
1. **Prima** di modificare: studiare docs esistenti
2. **Durante** lo sviluppo: aggiornare docs
3. **Dopo** lo sviluppo: finalizzare docs

## 🎯 Checklist Implementazione

### Prima di Iniziare
- [ ] Studiare docs del modulo target
- [ ] Comprendere la business logic
- [ ] Identificare pattern esistenti
- [ ] Scegliere priorità (autonomamente)

### Durante lo Sviluppo
- [ ] Seguire regole Laraxot
- [ ] Usare XotBase classi
- [ ] Applicare PHPStan level 10
- [ ] Scrivere test in Pest

### Dopo lo Sviluppo
- [ ] Verificare PHPStan 0 errori
- [ ] Eseguire test Pest
- [ ] Aggiornare documentazione
- [ ] Controllare PHPMD/PHP Insights

## 🔄 Git Workflow
- **Solo forward** - mai andare indietro
- **Analizzare** versioni precedenti ma non ripristinare
- **Mantenere** coerenza con versione corrente

## 📋 Quick Reference

### Classi da Estendere
| Categoria | Classe Base | Esempio |
|-----------|-------------|---------|
| Resource | `XotBaseResource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| Page | `XotBasePage` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| Widget | `XotBaseWidget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| Model | `BaseModel` | `Modules\{Module}\Models\BaseModel` |
| Migration | `XotBaseMigration` | `Modules\Xot\Database\Migrations\XotBaseMigration` |

### Pattern Comuni
- **Actions**: Usare Spatie Queueable Actions per business logic
- **Translations**: File di traduzione, mai stringhe hardcoded
- **Validation**: Form Requests o validazione nei componenti
- **Security**: Autorizzazione e autenticazione basate su Spatie Permission

## 🧠 Conoscenze Applicate

Questo documento rappresenta la sintesi delle conoscenze acquisite attraverso:
- Analisi approfondita della documentazione esistente
- Studio dei pattern di codice nel codebase
- Comprensione della filosofia architetturale
- Identificazione delle best practices consolidate

---

**Stato**: Documento Vivo - Aggiornare con nuove scoperte
**Principio**: La documentazione è la memoria viva del sistema
