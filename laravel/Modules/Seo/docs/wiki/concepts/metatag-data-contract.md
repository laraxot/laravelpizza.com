---
title: "MetatagDataContract — contratto DTO metadati SEO"
type: concept
module: Seo
tags: [contract, metatag, dto, seo, placement]
created: 2026-07-12
updated: 2026-07-12
qmd: "Seo MetatagDataContract app Contracts DTO boundary no Interfaces suffix verified"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./no-app-support-queueable-actions.md
  - ../../../../../../docs/wiki/rules/models-contracts-placement.md
  - ../../../../../../docs/wiki/memories/contract-suffix-no-interfaces-folder.md
  - ../../../../../../docs/wiki/bmad/architecture-models-contracts-placement.md
status: active
---

# MetatagDataContract

## Scopo (business)

`MetatagData` trasporta title, description, Open Graph, canonical e campi extra per ogni pagina FO/BO. Il **contratto** fissa cosa può leggere un consumer (Facade, Blade, Livewire) senza legarlo alla classe Spatie Data concreta.

## Perché `Contracts/` e non `Interfaces/`

| ❌ Vietato | ✅ Canonico |
|-----------|-------------|
| `app/Interfaces/MetatagDataInterface.php` | `app/Contracts/MetatagDataContract.php` |
| `Modules\Seo\Interfaces\MetatagDataInterface` | `Modules\Seo\Contracts\MetatagDataContract` |
| Suffisso `*Interface` | Suffisso `*Contract` (allineato a Laravel `Illuminate\Contracts\*`) |

**Religione Laraxot:** un contratto è un **accordo** tra moduli/componenti, non un dettaglio di implementazione PHP. Il suffisso `Contract` e la cartella `app/Contracts/` sono il linguaggio comune del monorepo (Xot, User, Notify, Rating).

**Zen:** la cartella `Interfaces/` duplica un concetto già nominato `Contracts` → rumore cognitivo, due modi di fare la stessa cosa.

## Perché `app/Contracts/` e non `Models/Contracts/`

`MetatagData` è un **DTO** (Spatie Laravel Data + `Wireable`), non un modello Eloquent.

| Tipo | Path |
|------|------|
| Capacità solo **Model** (`getKey`, morph, …) | `app/Models/Contracts/` |
| Boundary **DTO / servizio / port** | `app/Contracts/` |

Vedi [models-contracts-placement](../../../../../../docs/wiki/rules/models-contracts-placement.md) e ADR Comment su `Models/Contracts` vs `app/Contracts`.

## Implementazione

```php
// app/Contracts/MetatagDataContract.php
interface MetatagDataContract { /* getter read-only */ }

// app/Data/MetatagData.php
class MetatagData extends Data implements MetatagDataContract, Wireable { … }

// app/Adapters/MetatagFacadeAdapter.php — delega a Actions Metatag/*
public function get(): MetatagDataContract
```

`Metatag` Facade espone `@method static MetatagDataContract get()` — i consumer type-hintano il contratto, non la concrete class.

## Stato verifica (2026-07-12)

- `app/Interfaces/` **assente** nel modulo Seo
- `app/Support/` **assente** (2026-07-12)
- Consumer canonici: `MetatagData`, `MetatagFacadeAdapter` (`app/Adapters/`), Actions `GetMetatagDataAction`, Facade `Metatag`
- Audit: `bash bashscripts/tools/check-module-contracts-naming.sh` → OK
- Test: `Modules/Seo/tests/Unit/Data/MetatagDataTest.php` → `MetatagDataContract`

## Checklist nuovo contratto nel modulo Seo

1. Nome file `*{Contract}.php`, mai `*Interface`
2. Namespace `Modules\Seo\Contracts\*`
3. Se solo Eloquent → `Models/Contracts/` (raro in Seo)
4. Implementazione concreta in `Data/`, `Actions/` o `Models/`
5. Test: `expect($impl)->toBeInstanceOf(*Contract::class)`

## Collegamenti

- [provider-contracts-naming](../../../../Notify/docs/provider-contracts-naming.md) — suffisso `Contract` (modulo Notify)
- [ponytail-audit-over-engineering](../../ponytail-audit-over-engineering.md) — S1 aggiornato: contratto valido, path/nome corretti
