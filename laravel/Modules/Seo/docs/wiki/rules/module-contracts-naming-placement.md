---
title: "Rule: suffisso Contract e collocazione contratti modulo"
type: rule
tags: [contract, interface, naming, module, placement]
created: 2026-07-12
updated: 2026-07-12
qmd: "module contracts naming Contract suffix no Interfaces folder placement rule"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../docs/wiki/memories/contract-suffix-no-interfaces-folder.md
  - ../../../../../../docs/wiki/memories/models-contracts-vs-app-contracts.md
  - ../concepts/metatag-data-contract.md
status: active
---

# Rule: naming e path dei contratti

## Obbligatorio

| Regola | Dettaglio |
|--------|-----------|
| Suffisso | `*Contract`, mai `*Interface` |
| Cartella | `app/Contracts/`, **mai** `app/Interfaces/` |
| Namespace | `Modules\{Modulo}\Contracts\{Name}Contract` |

```php
// ✅
namespace Modules\Seo\Contracts;
interface MetatagDataContract { }

// ❌
namespace Modules\Seo\Interfaces;
interface MetatagDataInterface { }
```

## Eccezione — capability interface

Un'interfaccia "capacità" (verbo/predicato, non un dato) non porta il suffisso `Contract`,
ma vive comunque sotto `app/Contracts/`, mai `app/Interfaces/`:

```php
// ✅ capacità, non contratto-dato — niente suffisso, ma cartella Contracts/
namespace Modules\Xot\Contracts;
interface HasTableFunctions { }

namespace Modules\Comment\Contracts;
interface CanComment { }
```

Vedi anche [contract-naming-suffix.md](./contract-naming-suffix.md#corretto) _(target mancante, verificato 2026-10-08)_ per l'elenco
delle eccezioni riconosciute (`CanComment`, `HasTableFunctions`, ...).

## Placement (con Models)

| Tipo | Path |
|------|------|
| Solo capacità **Eloquent** | `app/Models/Contracts/` |
| DTO, servizio, adapter | `app/Contracts/` |
| Owner altro modulo | contratto **owner**, non duplicare |

Vedi anche [models-contracts-placement.md](../../../../../../docs/wiki/rules/models-contracts-placement.md).

## Consumer

Type-hint il contratto nei servizi e nelle Facade:

```php
public function get(): MetatagDataContract;
```

L'implementazione concreta (`MetatagData`, model, adapter) dichiara `implements MetatagDataContract`.

## Trigger

- Nuovo file `*Interface.php` → STOP, rinominare in `*Contract.php` sotto `Contracts/`
- Audit trova `app/Interfaces/` → migrare in `app/Contracts/`; non creare `archive/` e non lasciare file attivi nel path sbagliato
- File storico da ritirare → suffisso `.old` in-place o rinomina forward-only esplicita; evitare `rm` su file con valore storico

## Canon

- [contract-suffix-no-interfaces-folder.md](../../../../../../docs/wiki/memories/contract-suffix-no-interfaces-folder.md)
- Notify: [provider-contracts-naming.md](../../../../Notify/docs/provider-contracts-naming.md)
