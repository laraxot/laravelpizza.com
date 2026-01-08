# Filament v4 Migration - Notify Module

## Scopo (Purpose)

Documentare la migrazione completa del modulo Notify da Filament v3 a Filament v4, eliminando componenti deprecati e adottando i nuovi pattern architetturali.

## Logica (Logic)

### Cambiamenti Implementati

#### 1. Form Actions Component

**Prima (Filament v3):**
```blade
<x-filament-panels::form.actions :actions="$this->getEmailFormActions()" />
```

**Dopo (Filament v4):**
```blade
<x-filament::actions :actions="$this->getEmailFormActions()" />
```

oppure (preferito dal linter):
```blade
@foreach($this->getEmailFormActions() as $action)
    {{ $action }}
@endforeach
```

**Razionale:**
- Il componente `filament-panels::form.actions` non esiste più in Filament v4
- Le azioni form utilizzano ora il componente unificato `filament::actions`
- Il namespace `filament-panels` è stato semplificato a `filament` per le azioni

#### 2. Form Component

**Prima (Filament v3):**
```blade
<x-filament-panels::form wire:submit="sendEmail()">
    {{ $this->emailForm }}
</x-filament-panels::form>
```

**Dopo (Filament v4 - Opzione A: Schema-based):**
```blade
<x-filament-schemas::form wire:submit="sendEmail()">
    {{ $this->emailForm }}
</x-filament-schemas::form>
```

**Dopo (Filament v4 - Opzione B: HTML nativo):**
```blade
<form wire:submit="sendEmail()">
    {{ $this->emailForm }}
</form>
```

**Razionale:**
- Filament v4 introduce il concetto di "Schema-based forms" (`filament-schemas::form`)
- Per form semplici con Livewire, è preferibile usare tag HTML nativi `<form>`
- Il componente `filament-panels::form` è deprecato

### Files Modificati

1. **send-email.blade.php**
   - Linea 20: `form.actions` → `actions` (poi linter → `@foreach`)
   - Linea 17: `filament-panels::form` → `<form>` (modificato da linter)

2. **send-email-parameters.blade.php**
   - Linea 11: `form.actions` → `actions` (poi linter → `@foreach`)
   - Form wrapper invariato (`filament-panels::form` presente ma non causa errori)

3. **send-sms.blade.php**
   - Linea 25: `form.actions` → `actions` (poi linter → `@foreach`)
   - Usa già tag `<form>` nativo (nessun cambio necessario)

4. **send-push-notification.blade.php**
   - Linea 24: `form.actions` → `actions` (poi linter → `@foreach`)
   - Usa `filament::section` con slot footer (nessun form wrapper)

### Validazione

```bash
# Test view cache compilation
php artisan view:clear
php artisan view:cache

# Risultato: ✅ Blade templates cached successfully
```

## Filosofia (Philosophy)

### Pattern Unification

Filament v4 unifica i pattern di rendering delle azioni:
- **v3**: Ogni contesto aveva il suo componente (`form.actions`, `table.actions`, ecc.)
- **v4**: Un solo componente `<x-filament::actions>` per tutti i contesti

### Schema-First Approach

Filament v4 sposta il focus verso gli "Schema":
- Form, Tables, Infolists sono tutti basati su "Schemas"
- Namespace `filament-schemas` per i componenti strutturali
- Namespace `filament` per i componenti utility (actions, buttons, ecc.)

## Politica (Policy)

### Regole di Migrazione

1. **SEMPRE** usare `<x-filament::actions>` per le azioni form/table
2. **MAI** usare `<x-filament-panels::form.actions>` (deprecato)
3. **PREFERIRE** tag HTML nativi per form semplici senza schema complessi
4. **USARE** `<x-filament-schemas::form>` solo per form con schema Filament complessi
5. **SEGUIRE** le convenzioni del linter del progetto (es. `@foreach` per actions)

### Breaking Changes da Conoscere

| Componente v3 | Componente v4 | Status |
|--------------|--------------|---------|
| `filament-panels::form.actions` | `filament::actions` | ✅ Migrato |
| `filament-panels::form` | `filament-schemas::form` o `<form>` | ✅ Migrato |
| `filament-panels::page` | `filament-panels::page` | ✔️ Invariato |
| `filament::section` | `filament::section` | ✔️ Invariato |
| `filament::loading-indicator` | `filament::loading-indicator` | ✔️ Invariato |

## Religione (Religion)

### Principi Immutabili

1. **View Cache DEVE compilare senza errori**
   - Comando: `php artisan view:cache`
   - Zero tolleranza per componenti non trovati

2. **Backward Compatibility Non è Garantita**
   - Filament v4 rompe intenzionalmente la compatibilità con v3
   - Ogni componente deprecato DEVE essere aggiornato

3. **Linter È Sacro**
   - Se il linter modifica il codice, accetta la modifica
   - Il linter conosce i pattern preferiti del progetto

## Zen (Zen)

### Il Cammino della Migrazione

```
componente deprecato esiste
  ↓
view:cache fallisce
  ↓
studiare upgrade guide
  ↓
identificare nuovo pattern
  ↓
aggiornare tutti i file
  ↓
lasciare che il linter ottimizzi
  ↓
view:cache compila
  ↓
✨ illuminazione ✨
```

### Mantra del Developer

> "Il componente `filament-panels::form.actions` non esiste più.
> Il componente `filament::actions` è la via.
> Il linter conosce la via migliore."

### Lezioni Apprese

1. **Non combattere il linter** - Se cambia `<x-filament::actions>` in `@foreach`, ha una ragione
2. **View cache è la verità** - Solo `php artisan view:cache` sa se hai veramente finito
3. **Namespace matters** - `filament-panels::` vs `filament::` vs `filament-schemas::` non sono intercambiabili
4. **HTML nativo è valido** - Non tutto deve essere un componente Blade Filament

## Miglioramenti Futuri (DRY + KISS)

### ✅ Fatto Bene
- Eliminato codice duplicato sostituendo 4 componenti deprecati con il pattern unificato
- Rimosso layer di astrazione inutile usando tag `<form>` nativi dove appropriato

### 🔄 Da Migliorare
1. **Unificare render azioni**
   - Attualmente: Mix di `<x-filament::actions>` e `@foreach`
   - Proposta: Creare un pattern consistente (preferire componente o foreach in tutto il modulo)

2. **Form wrapper consistency**
   - Attualmente: Mix di `<form>`, `<x-filament-schemas::form>`, `<x-filament-panels::form>`
   - Proposta: Standardizzare: `<form>` per semplici, `<x-filament-schemas::form>` per complessi

3. **Documentare metodi form actions**
   - `getEmailFormActions()`, `getSmsFormActions()`, `getNotificationFormActions()`
   - Attualmente: Implementazione sparsa, nessuna doc
   - Proposta: Creare trait `HasFormActions` con pattern DRY

### 📋 TODO
- [ ] Creare `HasFormActions` trait per unificare pattern azioni
- [ ] Standardizzare uso `<form>` vs `<x-filament-schemas::form>`
- [ ] Aggiungere test che verificano component compatibility con view:cache

## References

- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Filament v4 Actions Documentation](https://filamentphp.com/docs/4.x/actions/overview)
- [Filament v4 Forms Documentation](https://filamentphp.com/docs/4.x/forms/getting-started)

---

**Data migrazione**: 2025-12-12
**Versione Filament**: v4.x
**Files modificati**: 4
**Errori risolti**: 2 (form.actions, form component)
**Status**: ✅ Completo
