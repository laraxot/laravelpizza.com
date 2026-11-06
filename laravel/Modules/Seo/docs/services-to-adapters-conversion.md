---
qmd: "services to adapters conversion"
issues: []
discussions: []
title: "Seo — da Services/Support ad Actions/Adapters"
type: concept
module: Seo
tags: [seo, queueable-action, adapters, refactoring, no-services]
created: 2026-07-16
updated: 2026-07-16
related:
  - ../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
status: active
---

# Seo — conversione Services/Support → Actions/Adapters

## Contesto

Regola aurea del monorepo (2026-07-13): `app/Services/` e `app/Support/` non devono
esistere in nessun modulo. La logica di dominio vive in `app/Actions/{Context}/FooAction.php`
con il trait `Spatie\QueueableAction\QueueableAction` e un unico metodo `execute(...)`.

## Cosa conteneva il modulo Seo

Un solo file: `app/Services/MetatagService.php`.

## Analisi: perché NON è diventata una Action

`MetatagService` **non è logica di dominio stateless**: è un accumulatore *stateful*
per-request dei metadati SEO (title, description, og:*, ecc.), registrato come
**singleton** nel container e esposto tramite la facade `Modules\Seo\Facades\Metatag`.
Il suo valore sta nel mantenere lo stato mutabile costruito da chiamate successive
(`setTitle()`, `setDescription()`, ...), poi letto una volta con `get()` in fase di render.

Una `QueueableAction` espone un solo `execute(...)` **senza stato**: forzare questa
forma spezzerebbe la semantica della facade coordinator. Per questo, secondo la tabella
canonica di Xot ([queueable-action-trait-mandatory](../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md)),
un **Facade coordinator** appartiene a `app/Adapters/`, non a `app/Actions/`.

## Conversione applicata

| Prima | Dopo |
|-------|------|
| `app/Services/MetatagService.php` (`Modules\Seo\Services\MetatagService`) | `app/Adapters/MetatagManager.php` (`Modules\Seo\Adapters\MetatagManager`) |

- Codice invariato: stesso comportamento, solo namespace/cartella corretti.
- Facade `Metatag` aggiornata (`getFacadeAccessor()` → `MetatagManager::class`).
- `SeoServiceProvider` aggiornato (binding singleton + `provides()`).
- Test aggiornati (Feature + Unit).
- Il vecchio file rinominato `MetatagService.php.bak` (mai `git rm`).

## Nota su GenerateSocialShareLinksAction

`app/Actions/GenerateSocialShareLinksAction.php` era già una vera Action con
QueueableAction ed `execute()` stateless (costruisce URL di condivisione da un DTO):
esempio corretto di logica di dominio, lasciata invariata.

## Filosofia QueueableAction vs Adapter

- **Action** (`app/Actions/`): un'operazione di dominio, stateless, `execute(...)`,
  invocata con `app(FooAction::class)->execute(...)`, opzionalmente accodabile.
- **Adapter** (`app/Adapters/`): coordinatore di facade / wrapper di stato o SDK,
  può mantenere stato per-request (singleton).
