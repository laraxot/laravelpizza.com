# Regola XotBaseSection - Politica, Filosofia, Religione, Zen

## Scopo (Purpose)

**REGOLA FONDAMENTALE**: NON estendere mai `Filament\Schemas\Components\Section` direttamente.
SEMPRE estendere `Modules\Xot\Filament\Schemas\Components\XotBaseSection`.

## Logica (Logic)

### ❌ SBAGLIATO - Estensione Diretta Filament
```php
use Filament\Schemas\Components\Section;

class AddressSection extends Section
{
    // SBAGLIATO! Viola la politica Laraxot
}
```

### ✅ CORRETTO - Estensione XotBaseSection
```php
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class AddressSection extends XotBaseSection
{
    // CORRETTO! Segue la politica Laraxot
}
```

## Filosofia (Philosophy)

### Perché XotBaseSection e non Section?

1. **Centralizzazione delle Funzionalità**: XotBaseSection fornisce metodi e comportamenti comuni a tutti i progetti Laraxot
2. **Estensibilità**: Possiamo aggiungere funzionalità globali senza modificare ogni Section
3. **Consistenza**: Tutti i componenti seguono lo stesso pattern architetturale
4. **Manutenibilità**: Un solo punto per aggiornamenti e fix

### Gerarchia di Estensione

```
Filament\Schemas\Components\Section (Filament v4 base)
    ↓
Modules\Xot\Filament\Schemas\Components\XotBaseSection (Laraxot base)
    ↓
Modules\Geo\Filament\Forms\Components\AddressSection (Module-specific)
Modules\<nome progetto>\Filament\Forms\Components\CompanySection
Modules\Notify\Filament\Forms\Components\ContactSection
...
```

## Politica (Policy)

### Regole Obbligatorie

1. **SEMPRE** estendere XotBaseSection, MAI Section direttamente
2. **SEMPRE** chiamare `parent::setUp()` nel metodo setUp()
3. **SEMPRE** posizionare Section nei namespace `Modules\{Module}\Filament\Forms\Components\`
4. **MAI** sovrascrivere metodi core senza buona ragione documentata

### Controllo Violazioni

```bash
# Trova tutte le violazioni nel codebase
grep -r "extends Section" Modules/*/app/Filament --include="*.php"

# Dovrebbe restituire 0 risultati (solo XotBaseSection estende Section)
```

## Religione (Religion)

### Dogmi Immutabili

> **"Thou shalt not extend Section directly"**
> Solo XotBaseSection può estendere Section. Tutti gli altri devono estendere XotBaseSection.

> **"One base to rule them all"**
> Un solo punto di estensione per tutte le Section del progetto.

> **"Follow the chain"**
> Segui sempre la catena di estensione: Filament → Xot → Module.

## Zen (Zen)

### Il Cammino della Section

```
Filament fornisce il componente base
  ↓
Xot lo estende con logica di progetto
  ↓
Module lo specializza per il dominio
  ↓
✨ Armonia ✨
```

### Koan della Section

> Un developer chiede: "Perché non posso estendere Section direttamente?"
> Il master risponde: "Quando estendiestendere Section, estendi solo Filament.
> Quando estendi XotBaseSection, estendi l'intero ecosistema Laraxot."

## Errori Comuni

### Errore 1: Estensione Diretta

**Sintomo:**
```php
use Filament\Schemas\Components\Section;

class MySection extends Section { }
```

**Fix:**
```php
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class MySection extends XotBaseSection { }
```

### Errore 2: disableLiveUpdates Non Esiste

**Sintomo:**
```
Method Modules\<nome progetto>\Filament\Forms\Components\CompanySection::disableLiveUpdates does not exist.
```

**Causa:** `disableLiveUpdates` è una property, non un metodo. Deve essere impostata, non chiamata.

**Fix:**
```php
class CompanySection extends XotBaseSection
{
    protected bool $disableLiveUpdates = false; // Property, not method!

    protected function setUp(): void
    {
        parent::setUp();
        // Non chiamare $this->disableLiveUpdates() !
    }
}
```

## Checklist Implementazione

- [ ] Import `use Modules\Xot\Filament\Schemas\Components\XotBaseSection;`
- [ ] Estendi `class MySection extends XotBaseSection`
- [ ] Chiama `parent::setUp()` nel setUp()
- [ ] Non usare metodi `disableLiveUpdates()` - è una property
- [ ] Documenta il perché della Section nel PHPDoc
- [ ] Test che la Section renderizza correttamente

## References

- `Modules/Xot/app/Filament/Schemas/Components/XotBaseSection.php` - Base class source
- `Modules/Geo/app/Filament/Forms/Components/AddressSection.php` - Esempio corretto
- Filament v4 Documentation: https://filamentphp.com/docs/4.x/forms/layout/section

---

**Data creazione**: 2025-12-12
**Status**: ✅ Regola attiva e obbligatoria
**Priorità**: CRITICA - Violazioni bloccano il codice
