# Regole Critiche del Progetto - Riepilogo

## 📋 Overview

Questo documento raccoglie le **regole assolute e inviolabili** del progetto Laraxot/PTVX. Queste regole sono state stabilite per garantire qualità, organizzazione e workflow prevedibile.

**Status**: VINCOLANTI per tutti i membri del team

---

## 🚫 Regola 1: Git - Mai Tornare Indietro

### Principio

**NON si fa MAI checkout, revert, o reset a versioni precedenti del codice.**

### Comandi Vietati

```bash
❌ git checkout <old-commit>
❌ git reset --hard <commit>
❌ git revert <commit>
❌ git restore --source=<old-commit>
```

### Approccio Corretto

✅ **Fix Forward**: Ogni errore si corregge con un nuovo commit che va avanti.

```bash
# Correggi l'errore
nano file.php

# Committa il fix
git add file.php
git commit -m "fix: corretto errore X"
git push
```

### Motivazioni

- **Tracciabilità completa**: Ogni errore e fix documentati
- **Sicurezza team**: Nessuna perdita di lavoro altrui
- **Audit trail**: Storia immutabile per compliance
- **Debugging**: Si vedono pattern di errori e soluzioni

### Documentazione

- [.cursor/rules/git-never-go-back.mdc](../../../.cursor/rules/git-never-go-back.mdc)
- [Xot/docs/git-never-go-back-rule.md](./git-never-go-back-rule.md)

---

## 📂 Regola 2: Script Solo in bashscripts/

### Principio

**TUTTI gli script devono essere in bashscripts/, categorizzati.**

### Path Vietati

```bash
❌ /var/www/_bases/base_ptvx_fila4_mono/script.sh                  # Root
❌ /var/www/_bases/base_ptvx_fila4_mono/laravel/analyze.sh         # Laravel
❌ /var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/util.sh # Moduli
```

### Path Corretti

```bash
✅ /var/www/_bases/base_ptvx_fila4_mono/bashscripts/analysis/script.sh
✅ /var/www/_bases/base_ptvx_fila4_mono/bashscripts/quality-assurance/phpstan.sh
✅ /var/www/_bases/base_ptvx_fila4_mono/bashscripts/git/sync.sh
✅ /var/www/_bases/base_ptvx_fila4_mono/bashscripts/mcp/custom-server.js
```

### Categorie

- `analysis/` - Analisi codice
- `quality-assurance/` - PHPStan, Pint, Quality
- `git/` - Operazioni Git
- `database/` - Database operations
- `maintenance/` - Manutenzione sistema
- `utilities/` - Utility generali
- `testing/` - Testing
- `fix/` - Fix automatici
- `mcp/` - Server MCP custom

### Workflow

1. Crea script in categoria appropriata
2. `chmod +x` per renderlo eseguibile
3. Documenta in `bashscripts/docs/nome-script.md`

### Documentazione

- [.cursor/rules/script-location-mandatory.mdc](../../../.cursor/rules/script-location-mandatory.mdc)
- [Xot/docs/script-location-rules.md](./script-location-rules.md)
- [bashscripts/README.md](../../../bashscripts/README.md)

---

## 🎯 Regola 3: PHPStan Level 10 Sempre

### Principio

**MAI ignorare errori PHPStan. Tutto il codice deve passare Level 10.**

### Vietato

```php
❌ // @phpstan-ignore-next-line
❌ // @phpstan-ignore method.nonObject
❌ Abbassare level in phpstan.neon
```

### Corretto

✅ Analizza l'errore  
✅ Studia documentazione  
✅ Correggi il codice  
✅ Zero suppressions

### Script

```bash
# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/NomeModulo --level=10

# Analisi tutti i moduli
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/quality-assurance/phpstan_all_modules.sh
```

### Documentazione

- Vedere regole Laravel12 in `.cursor/rules`
- [Sigma/docs/phpstan-fixes-2025.md](../../Sigma/docs/phpstan-fixes-2025.md)

---

## 🌐 Regola 4: Traduzioni Automatiche (No Hardcoded)

### Principio

**MAI usare ->label(), ->placeholder(), ->helperText() nei componenti Filament.**

### Vietato

```php
❌ TextInput::make('name')->label('Nome')
❌ Select::make('type')->placeholder('Seleziona tipo')
❌ EditAction::make()->modalHeading('Modifica')
```

### Corretto

```php
✅ TextInput::make('name')
✅ Select::make('type')
✅ EditAction::make()

// Traduzioni in: Modules/{Module}/lang/{locale}/
```

### Motivazioni

- **Localizzazione**: Supporto multilingua automatico
- **Manutenibilità**: Traduzioni centralizzate
- **Consistenza**: Stesso sistema in tutto il progetto

### Documentazione

- [filament_best_practices](.cursor/rules/)
- [Framework Specifics](../../../docs/claude/framework-specifics.md)

---

## 🏗️ Regola 5: Estendere Sempre Classi Base Xot

### Principio

**Mai estendere classi Filament/Laravel direttamente. Sempre usare classi Xot base.**

### Vietato

```php
❌ use Filament\Resources\Resource;
   class MyResource extends Resource

❌ use Illuminate\Support\ServiceProvider;
   class MyProvider extends ServiceProvider

❌ use Filament\Resources\RelationManagers\RelationManager;
   class MyRelation extends RelationManager
```

### Corretto

```php
✅ use Modules\Xot\Filament\Resources\XotBaseResource;
   class MyResource extends XotBaseResource

✅ use Modules\Xot\Providers\XotBaseServiceProvider;
   class MyProvider extends XotBaseServiceProvider

✅ use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
   class MyRelation extends XotBaseRelationManager
```

### Motivazioni

- **Centralizzazione**: Logica comune in un punto
- **Aggiornamenti**: Fix propagano a tutti i moduli
- **Consistenza**: Comportamento uniforme
- **DRY**: No duplicazione logica

---

## 🐘 Regola 6: Eloquent Properties - Usare isset()

### Principio

**MAI usare property_exists() con modelli Eloquent. Sempre isset().**

### Vietato

```php
❌ if (property_exists($user, 'full_name')) {
    return $user->full_name;
}
```

### Corretto

```php
✅ if (isset($user->full_name)) {
    return $user->full_name;
}

✅ return $user->full_name ?? $user->fallback ?? 'default';
```

### Motivazioni

I modelli Eloquent usano magic methods (`__get`, `__set`) per:
- Attributi database
- Relazioni
- Accessors/Mutators  
- Attributi schemaless

`property_exists()` restituisce `false` per tutti questi, ma `isset()` funziona correttamente.

### Documentazione

- [docs/claude/eloquent-properties.md](../../../docs/claude/eloquent-properties.md)

---

## 📝 Regola 7: Documentazione nei Moduli

### Principio

**Documentazione va SOLO in Modules/{Module}/docs/, MAI in root docs/**

### Vietato

```bash
❌ /var/www/_bases/base_ptvx_fila4_mono/docs/user-guide.md
❌ /var/www/_bases/base_ptvx_fila4_mono/laravel/docs/api.md
```

### Corretto

```bash
✅ /var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/docs/user-guide.md
✅ /var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/docs/api.md
```

### Motivazioni

- **Modularità**: Ogni modulo autonomo
- **Portabilità**: Modulo = Codice + Docs
- **Responsabilità**: Clear ownership della documentazione

### Documentazione

- [docs-location-policy](.cursor/rules/)

---

## 🔧 Regola 8: Namespace Puliti (No App/)

### Principio

**Namespace moduli: Modules\{Module}\, MAI Modules\{Module}\App\**

### Vietato

```php
❌ namespace Modules\User\App\Services;
❌ namespace Modules\Rating\App\Models;
```

### Corretto

```php
✅ namespace Modules\User\Services;
✅ namespace Modules\Rating\Models;
```

### Motivazioni

- **Semplicità**: Namespace più corti e puliti
- **PSR-4**: Allineamento con standard
- **Laraxot Convention**: Standard framework

---

## 📊 Checklist Pre-Commit

Prima di ogni commit, verifica:

- [ ] ❌ Non sto usando git reset/revert/checkout old
- [ ] ✅ Fix forward con nuovo commit
- [ ] 📂 Script in bashscripts/ categorizzati
- [ ] 🧪 PHPStan Level 10 passa (0 errori)
- [ ] 🎯 Nessun ->label() hardcoded
- [ ] 🏗️ Estendo classi Xot base
- [ ] 🐘 Uso isset() non property_exists()
- [ ] 📝 Docs in Modules/{Module}/docs/
- [ ] 🔧 Namespace puliti (no App/)
- [ ] ✅ declare(strict_types=1) presente

## 🚨 Enforcement

### Code Review

Ogni PR deve essere verificata per:
- Rispetto di tutte le 8 regole critiche
- Documentazione aggiornata
- Test passano
- PHPStan Level 10 clean

### Auto-Check

Script di verifica automatica:

```bash
# Verifica script fuori posto
find . -maxdepth 1 -name "*.sh" -type f

# Verifica PHPStan
./vendor/bin/phpstan analyse --level=10

# Verifica property_exists()
grep -r "property_exists" Modules/ --include="*.php"

# Verifica label() hardcoded
grep -r "->label(" Modules/ --include="*.php"
```

## 📚 Documentazione Completa

### Regole Cursor

- [.cursor/rules/git-never-go-back.mdc](../laravel/.cursor/rules/git-never-go-back.mdc)
- [.cursor/rules/script-location-mandatory.mdc](../laravel/.cursor/rules/script-location-mandatory.mdc)

### Documentazione Moduli

- [Xot/docs/git-never-go-back-rule.md](../laravel/Modules/Xot/docs/git-never-go-back-rule.md)
- [Xot/docs/script-location-rules.md](../laravel/Modules/Xot/docs/script-location-rules.md)
- [Xot/docs/mcp-servers-configuration.md](../laravel/Modules/Xot/docs/mcp-servers-configuration.md)

### bashscripts Docs

- [docs/mcp-configuration.md](docs/mcp-configuration.md)
- [docs/phpstan-all-modules.md](docs/phpstan-all-modules.md)
- [docs/reload-env-config.md](docs/reload-env-config.md)

## 🎓 Filosofia

Queste regole non sono restrizioni arbitrarie, ma **principi che emergono dall'esperienza**:

- **Git forward-only**: Protegge il lavoro di tutti, migliora debugging
- **bashscripts/**: Organizzazione chiara, facile manutenzione
- **PHPStan Level 10**: Qualità del codice, meno bug in produzione
- **No hardcoded strings**: Internazionalizzazione, manutenibilità
- **Xot base classes**: DRY, aggiornamenti centralizzati
- **isset() vs property_exists()**: Compatibilità Eloquent magic
- **Docs nei moduli**: Modularità, portabilità
- **Namespace puliti**: Semplicità, standard

Ogni regola ha un **perché** basato su problemi reali affrontati nel progetto.

## 🔗 Collegamenti Esterni

- [Model Context Protocol](https://modelcontextprotocol.io/)
- [Laravel Documentation](https://laravel.com/docs/12.x)
- [PHPStan Documentation](https://phpstan.org/)
- [Filament Documentation](https://filamentphp.com/docs)

---

**Versione**: 1.0  
**Data**: 2 Dicembre 2025  
**Autore**: Team Laraxot  
**Status**: VINCOLANTE

⚠️ **IMPORTANTE**: Violazioni di queste regole devono essere corrette immediatamente durante code review. Nessuna eccezione.

