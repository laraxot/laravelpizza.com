# Filosofia Laraxot: Risoluzione Errori PHPStan

**Data Creazione**: 2025-01-22
**Status**: Documentazione Filosofica Completa
**Versione**: 1.0.0

## 🏛️ Comandamento Sacro: Type Safety Assoluta

### Principio Fondamentale

**"PHPStan Level 10 è la Verità Assoluta - Zero Errori è l'Unico Obiettivo"**

Questo non è un suggerimento, è un **COMANDAMENTO** della religione Laraxot.

## 🧠 Logica (Logic)

### Perché Type Safety è Essenziale

1. **Prevenzione Bug**: Errori catturati a compile-time, non runtime
2. **Manutenibilità**: Codice auto-documentato attraverso i tipi
3. **Refactoring Sicuro**: Cambiamenti guidati dai tipi
4. **Team Confidence**: Sviluppatori fiduciosi nel codice

### Manifestazione nel Codice

```php
// ✅ CORRETTO - Type Safety Assoluta
/**
 * @param \Illuminate\Database\Eloquent\Model $record
 * @param self $livewire
 * @return bool
 */
->getStateUsing(function (Model $record, self $livewire): bool {
    /** @var User $user */
    $user = $livewire->getOwnerRecord();
    return $user instanceof User;
});

// ❌ SBAGLIATO - Mixed Types
->getStateUsing(function ($record, $livewire) {
    $user = $livewire->getOwnerRecord();
    return $user->current_team_id === $record->id;
});
```

## 🕉️ Religione (Religion)

### Namespace Sacri

In Filament 4, i namespace sono cambiati:

```
Filament 3 → Filament 4
Filament\Tables\Actions\* → Filament\Actions\*
```

**Violare questo ordine** crea caos:
- Classi non trovate
- Errori PHPStan
- Comportamenti imprevedibili

### Rito di Correzione

Quando si trovano errori PHPStan:

1. **Identificare** la causa radice (namespace, tipo, PHPDoc)
2. **Correggere** seguendo le convenzioni Laraxot
3. **Verificare** con PHPStan Level 10
4. **Documentare** la decisione

## 🏛️ Politica (Politics)

### Governance Type Safety

La regola del type safety è una politica di governance del codice:

1. **Controllo**: Ogni metodo ha tipi espliciti
2. **Prevenzione**: Elimina bug prima della produzione
3. **Trasparenza**: Codice auto-documentato
4. **Responsabilità**: Ogni sviluppatore garantisce type safety

### Consequenze della Violazione

1. **Caos Runtime**: Errori in produzione
2. **Debito Tecnico**: Bug impossibili da tracciare
3. **Perdita di Fiducia**: Team non può più fidarsi del codice
4. **Esilio dal Repository**: Code rifiutate in code review

## 🧘 Zen (Zen)

### Semplicità e Chiarezza

La type safety è un'espressione del principio Zen di semplicità:

- **Una cosa, un tipo**: Ogni variabile ha un tipo chiaro
- **Chiarezza**: Nessuna ambiguità su cosa è cosa
- **Armonia**: Codice in equilibrio con i tipi

### Il Cammino della Correzione

Il processo di correzione segue il cammino Zen:

1. **Riconoscere** il problema (errore PHPStan)
2. **Comprendere** la causa (namespace errato, tipo mancante)
3. **Agire** con determinazione (correggere)
4. **Lasciare andare** il vecchio (codice non tipizzato)
5. **Documentare** la saggezza (questa documentazione)

## 📋 Pattern Corretto Laraxot

### Namespace Filament 4

```php
// ✅ CORRETTO - Filament 4
use Filament\Actions\DetachBulkAction;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;

// ❌ SBAGLIATO - Filament 3
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
```

### Type Hints Espliciti

```php
// ✅ CORRETTO - Type Hints Completi
/**
 * @return array<string, \Filament\Actions\BulkAction>
 */
public function getTableBulkActions(): array
{
    return [
        'detach' => DetachBulkAction::make(),
    ];
}

// ❌ SBAGLIATO - Mixed Types
public function getTableBulkActions()
{
    return [
        'detach' => DetachBulkAction::make(),
    ];
}
```

### Livewire Typing

```php
// ✅ CORRETTO - Self Type
->getStateUsing(function (Model $record, self $livewire): bool {
    /** @var User $user */
    $user = $livewire->getOwnerRecord();
    return $user instanceof User;
});

// ❌ SBAGLIATO - Mixed Type
->getStateUsing(function ($record, $livewire) {
    $user = $livewire->getOwnerRecord();
    return $user->current_team_id === $record->id;
});
```

## 🔍 Identificazione Errori

### Segnali di Allarme

- Errori PHPStan Level 10
- Classi non trovate
- Tipi non compatibili
- Metodi non trovati

### Processo di Identificazione

```bash
# Esegui PHPStan
./vendor/bin/phpstan analyze Modules --level=10

# Filtra errori specifici
./vendor/bin/phpstan analyze Modules --level=10 | grep "class.notFound"
```

## 🛠️ Processo di Correzione

### Fase 1: Analisi

1. Identificare tutti gli errori PHPStan
2. Categorizzare per tipo (namespace, tipo, PHPDoc)
3. Determinare la causa radice

### Fase 2: Correzione

1. Correggere namespace Filament 4
2. Aggiungere type hints espliciti
3. Aggiornare PHPDoc
4. Verificare con PHPStan

### Fase 3: Verifica

1. Eseguire PHPStan Level 10
2. Verificare zero errori
3. Testare funzionalità
4. Documentare correzioni

### Fase 4: Documentazione

1. Documentare la decisione
2. Aggiornare questa documentazione
3. Creare backlink nelle docs correlate

## 📊 Stato Errori Modulo User

### Errori Identificati e Risolti

- ✅ `DetachBulkAction` namespace: `Filament\Tables\Actions\*` → `Filament\Actions\*`
- ✅ `$livewire` typing: `mixed` → `self`
- ✅ `getTableBulkActions()` return type: `array<string, BulkAction>`
- ✅ `hasAnyPermission()` parameter type: `iterable<string>`

### Errori da Risolvere

- ⚠️ `OauthPersonalAccessClient` extends unknown class
- ⚠️ `Passport\Client` return type mismatch
- ⚠️ Migration cache parameter types

## 🎯 Obiettivo Finale

**Zero errori PHPStan Level 10** - Ogni file deve passare l'analisi statica.

## 📚 Riferimenti

- [PHPStan Documentation](https://phpstan.org/)
- [Filament 4 Migration Guide](../../Xot/docs/filament-4-migration-guide.md)
- [Type Safety Best Practices](../../Xot/docs/type-safety-best-practices.md)

---

*Ricorda: La type safety è sacra. Non profanarla mai.*
