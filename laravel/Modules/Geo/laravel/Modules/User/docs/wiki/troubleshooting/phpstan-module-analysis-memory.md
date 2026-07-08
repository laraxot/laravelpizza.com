---
title: "PHPStan User module analysis memory"
type: troubleshooting
module: User
tags: [phpstan, user, oom, cache, larastan]
created: "2026-06-18"
updated: "2026-06-18"
qmd: "User phpstan analyse Modules/User OOM 512M cache gate"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/102"
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - "../../../../../../docs/wiki/troubleshooting/phpstan-parallel-worker-oom.md"
  - "../../../../Xot/docs/phpstan-config-immutability.md"
  - "../index.md"
---

# PHPStan User module analysis memory

> Nota operativa per distinguere errori reali del modulo User da OOM/cache PHPStan.

## Sintomo

Il primo run:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/User
```

puo' fallire con:

```text
Child process error: PHPStan process crashed because it reached configured PHP memory limit: 512M
while running parallel worker
```

Questo non indica automaticamente errori nel codice User.

## Procedura verificata

1. Non modificare `laravel/phpstan.neon`.
2. Non creare file `.neon` alternativi.
3. Eseguire il gate sequenziale:

```bash
bash bashscripts/tools/phpstan-modules-gate.sh User
```

4. Se serve diagnosi fine, spezzare in batch con:

```bash
cd laravel
env XDEBUG_MODE=off CACHE_DRIVER=array CACHE_STORE=array \
  php -d memory_limit=2048M ./vendor/bin/phpstan analyse \
  --memory-limit 2048M --debug --no-progress Modules/User/app/<Area>
```

5. Rilanciare il comando richiesto dopo il warm-up/cache:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/User
```

## Esito 2026-06-18

Batch analizzate senza errori:

| Area | Esito |
|---|---|
| `Actions` | OK |
| `Contracts`, `Datas`, `Enums`, `Events` | OK |
| `Console`, `Http`, `Providers` | OK |
| `Models` | OK |
| `Application`, `Exceptions`, `Facades`, `Listeners`, `Livewire`, `Mail`, `Notifications`, `Observers`, `Rules`, `Support`, `Traits`, `View` | OK |
| `Filament/Actions`, `Forms`, `Pages`, `Traits`, `Widgets` | OK |
| `Filament/Clusters/*` | OK |
| `Filament/Resources/*` | OK |

Verifica finale:

```text
./vendor/bin/phpstan analyse Modules/User
[OK] No errors
635/635 files
```

## Regola

Se il run completo fallisce prima di mostrare errori tabellari, trattarlo come problema di runtime PHPStan/cache/OOM. Applicare il gate sequenziale e correggere codice solo quando PHPStan produce segnalazioni su file/linea.
