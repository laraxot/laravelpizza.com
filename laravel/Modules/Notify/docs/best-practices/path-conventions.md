---
title: "Convenzioni sui Percorsi"
type: concept
tags: [notify, docs, best-practices, path, conventions]
module: Notify
created: 2026-07-20
updated: 2026-07-20
qmd: "notify documentazione best practices path conventions convenzioni sui percorsi frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - ../README.md
  - ../architecture/README.md
  - ../conventions/README.md
  - ../rules/README.md
  - naming-conventions.md
---
# Convenzioni sui Percorsi 

## Regole Fondamentali

1. **Directory vs Namespace**
   - Le directory nel filesystem sono in lowercase: `app`, `config`, `resources`
   - I namespace possono essere in PascalCase ma devono mappare correttamente alle directory lowercase

2. **Struttura Directory Principale**
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)
   - `Modules/Notify/app/` (CORRETTO)
   - `Modules/Notify/App/` (ERRATO)

3. **Struttura Directory Actions**
   - `Modules/Notify/app/Actions/` (CORRETTO)
   - `Modules/Notify/App/Actions/` (ERRATO)

4. **Struttura Directory Datas**
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)
   - `Modules/Notify/app/Datas/` (CORRETTO)
   - `Modules/Notify/App/Datas/` (ERRATO)

## Namespace vs Directory

| Directory (filesystem) | Namespace PHP | Note |
|------------------------|---------------|------|
| `app/`                 | `Modules\Notify` | Nessun segmento "App" nel namespace |
| `app/Actions/`         | `Modules\Notify\Actions` | Il modulo definisce il proprio PSR-4 |
| `app/Datas/`           | `Modules\Notify\Datas` | Data objects utilizzati nel modulo |
| `app/Models/`          | `Modules\Notify\Models` | Modelli Eloquent |

## Errori Comuni da Evitare

1. **Mai utilizzare la "A" maiuscola nel percorso fisico della directory app**
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`
   - ✅ CORRETTO: `Modules/Notify/app/Actions/`
   - ❌ ERRATO: `Modules/Notify/App/Actions/`

2. **Mai aggiungere "App" nel namespace se non definito nel composer.json del modulo**
   - ✅ CORRETTO: `namespace Modules\Notify\Actions;`
   - ❌ ERRATO: `namespace Modules\Notify\App\Actions;`

3. **Mai creare directory con nomi inconsistenti rispetto alle convenzioni di Laravel**
   - Le directory standard `app`, `config`, `resources` devono sempre essere in lowercase
   - Le classi e i namespace utilizzano PascalCase ma puntano a percorsi in lowercase

## Riferimento PSR-4 nel composer.json

I moduli  definiscono il proprio mapping PSR-4 nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

Questo significa che il namespace `Modules\Notify` mappa alla directory `app/` del modulo, non alla directory principale. Pertanto, qualsiasi classe all'interno di `app/Actions/` avrà il namespace `Modules\Notify\Actions`, non `Modules\Notify\App\Actions`.
