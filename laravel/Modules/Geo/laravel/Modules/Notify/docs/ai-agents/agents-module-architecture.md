# AGENTS Module Architecture

Regole di architettura modulare per il progetto.

## Modulo Agnosticism - REGOLA FONDAMENTALE

**Il modulo Predict (e tutti i moduli) devono essere AGONISTICI!**

Non usare MAI dipendenze hardcoded come `Modules\Blog\Models\User`. Usa sempre `XotData`:

```php
// ❌ SBAGLIATO
\Modules\Blog\Models\User::count()

// ✅ CORRETTO
$userClass = \Modules\Xot\Datas\XotData::make()->getUserClass();
$userClass::query()->count()
```

Questo permette al modulo di funzionare in qualsiasi progetto senza dipendere da moduli specifici.

---

## Module Directory Structure

Ogni modulo segue questa struttura:

```
ModuleName/
├── Config/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Resources/
│   ├── js/
│   └── views/
├── Routes/
└── Services/
```

---

## Composer Merge Plugin Configuration

Il progetto usa **Wikimedia Composer Merge Plugin** per gestire le dipendenze dei moduli:

```json
"merge-plugin": {
    "include": ["Modules/*/composer.json"],
    "recurse": true,
    "merge-dev": true
}
```

### Regole Dipendenze Moduli

**Ogni pacchetto Composer DEVE risiedere nel modulo che lo utilizza**, non nel composer.json principale.

#### Principi Chiave

1. **Modulo = Unità di Deployment**: Ogni modulo è come un pacchetto composer standalone
2. **Autoload interno**: I moduli usano il proprio autoload PSR-4
3. **Dipendenze esplicite**: Ogni modulo dichiara le proprie dipendenze nel suo composer.json
4. **Merge automatico**: Composer Merge Plugin unisce tutti i composer.json dei moduli

#### Esempio - Modulo User

```json
{
    "name": "laraxot/module_user_fila5",
    "require": {
        "laravel/passport": "^13.0",
        "socialiteproviders/microsoft": "^4.8"
    }
}
```

#### Errori Comuni

- ❌ Includere `laravel/passport` in `laravel/composer.json` (deve essere solo nel modulo User)
- ❌ Includere pacchetti non utilizzati dal modulo principale
- ❌ Dimenticare di aggiornare il composer.json del modulo quando si aggiunge una dipendenza

#### Workflow Corretto

1. Se servono nuove dipendenze, aggiungile al `composer.json` del modulo appropriato
2. Non aggiungere MAI pacchetti al composer.json principale (`laravel/composer.json`)
3. Esegui `composer update` per aggiornare le dipendenze
4. Verifica che il merge plugin funzioni correttamente

---

## Git Submodules

### Package Management in Modules

I moduli possono contenere pacchetti esterni in cartelle `packages/` gestiti come git submodules:

```ini
#packages
[submodule "laravel/Modules/Lang/packages/lara-zeus/spatie-translatable"]
	path = laravel/Modules/Lang/packages/lara-zeus/spatie-translatable
	url = git@github.com:laraxot/spatie-translatable.git
```

### Comandi

```bash
# Initialize all submodules
git submodule update --init --recursive

# Update specific submodule
git submodule update --remote laravel/Modules/Lang/packages/lara-zeus/spatie-translatable

# Add new submodule
git submodule add git@github.com:user/repo.git Modules/ModuleName/packages/vendor/package

# Remove submodule
git submodule deinit path/to/submodule
git rm path/to/submodule
```

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [module-dependencies.md](./module-dependencies.md) - Più dettagliato
- [git-submodules.md](./git-submodules.md) - Dettagli git
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)
