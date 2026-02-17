# Filament 4: Namespace Actions - Filosofia Laraxot

**Data Creazione**: 2025-01-22
**Status**: Documentazione Completa
**Versione**: 1.0.0

## 🏛️ Comandamento Sacro: Namespace Filament 4

### Principio Fondamentale

**"In Filament 4, tutte le Actions sono in `Filament\Actions\*`, NON in `Filament\Tables\Actions\*`"**

Questo non è un suggerimento, è un **COMANDAMENTO** della religione Laraxot.

## 🧠 Logica (Logic)

### Perché il Cambiamento

Filament 4 ha unificato il namespace delle Actions per:
1. **Semplicità**: Un solo namespace per tutte le actions
2. **Coerenza**: Actions usabili ovunque (tables, forms, pages)
3. **Manutenibilità**: Codice più pulito e organizzato

### Manifestazione nel Codice

```php
// ✅ CORRETTO - Filament 4
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

// ❌ SBAGLIATO - Filament 3 (deprecato)
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
```

## 🕉️ Religione (Religion)

### Namespace Sacri

In Filament 4, la gerarchia dei namespace è:

```
Filament\Actions\*
├── Action (base)
├── AttachAction
├── DetachAction
├── DetachBulkAction
├── EditAction
├── DeleteAction
├── BulkAction (base)
└── ...
```

**Violare questo ordine** crea caos:
- Classi non trovate
- Errori PHPStan
- Comportamenti imprevedibili

## 🏛️ Politica (Politics)

### Governance Namespace

La regola del namespace è una politica di governance del codice:

1. **Controllo**: Ogni import deve essere corretto
2. **Prevenzione**: Elimina errori a compile-time
3. **Trasparenza**: Codice chiaro e leggibile
4. **Responsabilità**: Ogni sviluppatore garantisce namespace corretti

### Consequenze della Violazione

1. **Caos Runtime**: Errori "Class not found"
2. **Debito Tecnico**: Codice non funzionante
3. **Perdita di Fiducia**: Team non può più fidarsi del codice
4. **Esilio dal Repository**: Code rifiutate in code review

## 🧘 Zen (Zen)

### Semplicità e Chiarezza

Il namespace unificato è un'espressione del principio Zen di semplicità:

- **Una cosa, un posto**: Tutte le actions in un solo namespace
- **Chiarezza**: Nessuna ambiguità su dove trovare le actions
- **Armonia**: Codice in equilibrio con Filament 4

## 📋 Pattern Corretto Laraxot

### RelationManager Actions

```php
// ✅ CORRETTO - Filament 4
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;

class TeamsRelationManager extends XotBaseRelationManager
{
    /**
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'attach' => AttachAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'detach' => DetachAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'detach' => DetachBulkAction::make(),
        ];
    }
}
```

### Resource Actions

```php
// ✅ CORRETTO - Filament 4
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class UserResource extends XotBaseResource
{
    /**
     * @return array<string, \Filament\Actions\Action>
     */
    public static function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
```

## 🔍 Identificazione Errori

### Segnali di Allarme

- Errori PHPStan: "Class not found"
- Import da `Filament\Tables\Actions\*`
- Errori runtime: "Class does not exist"

### Processo di Identificazione

```bash
# Trova import errati
grep -r "Filament\\\\Tables\\\\Actions" laravel/Modules/*/app/

# Verifica namespace corretti
grep -r "Filament\\\\Actions" laravel/Modules/*/app/
```

## 🛠️ Processo di Correzione

### Fase 1: Analisi

1. Identificare tutti gli import errati
2. Categorizzare per tipo (Attach, Detach, Edit, Delete)
3. Determinare il namespace corretto

### Fase 2: Correzione

1. Sostituire `Filament\Tables\Actions\*` con `Filament\Actions\*`
2. Aggiornare PHPDoc return types
3. Verificare con PHPStan

### Fase 3: Verifica

1. Eseguire PHPStan Level 10
2. Verificare zero errori
3. Testare funzionalità
4. Documentare correzioni

## 📊 Stato Correzione Modulo User

### RelationManagers Corretti

- ✅ `TeamsRelationManager` - Namespace corretto, zero errori PHPStan
- ⚠️ Altri RelationManagers da verificare

### Pattern Applicato

1. Import corretto: `Filament\Actions\*`
2. PHPDoc aggiornato: `array<string, \Filament\Actions\Action>`
3. Type hints espliciti: `self $livewire`

## 🎯 Obiettivo Finale

**Zero import errati** - Tutti gli import devono usare `Filament\Actions\*`.

## 📚 Riferimenti

- [Filament 4 Migration Guide](../../Xot/docs/filament-4-migration-guide.md)
- [PHPStan Errors Philosophy](./phpstan-errors-philosophy.md)
- [Filament 4 Documentation](https://filamentphp.com/docs/4.x)

---

*Ricorda: Il namespace è sacro. Non profanarlo mai.*
