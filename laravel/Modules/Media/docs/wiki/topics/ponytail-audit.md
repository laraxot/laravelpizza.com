---
title: "Topic ponytail-audit"
type: digest
status: active
qmd: "digest ceiling 100 ponytail-audit"
---

# Topic ponytail-audit

Sintesi automatica di 3 documenti (chiave `ponytail-audit`).

## Ponytail audit — Media (over-engineering)

_Fonte: `ponytail-audit-over-engineering.md`_

# Ponytail audit — Media (over-engineering)

**Ultimo run:** 2026-06-30  
**Modulo:** upload, library, media Filament.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_ptvx_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_ptvx_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_ptvx_fila5/discussions/228)

## Findings

| # | Tag | Cosa | Sostituzione | Path |
|---|-----|------|--------------|------|
| M1 | `delete`→`.bak` | `BaseController` abstract vuoto, zero `extends` nel modulo | `Illuminate\Routing\Controller` o nessun base | `app/Http/Controllers/BaseController.php` |
| M2 | `stdlib` | `intervention/image` (da valutare in hub) | GD/Imagick se copertura sufficiente | `composer.json` |

## Azione proposta

Rename `.bak` su `BaseController.php` dopo grep globale. Nessun impatto se nessun riferimento.

## Collegamenti

- [00-index.md](./00-index.md)
---
- [00-index.md](./00-index.md)

## Ponytail-audit 2026-07-02: Media module findings

_Fonte: `ponytail-audit.md`_

# Ponytail-audit 2026-07-02: Media module findings

Source: repo-wide ponytail-audit pattern (same pass as Xot and Notify module findings, see
`Modules/Xot/docs/ponytail-audit-2026-07-02.md` and `Modules/Notify/docs/ponytail-audit-2026-07-02.md`).

## Finding

`Modules/Media/app/Contracts/PathGenerator.php` was an interface with a single near-implementer,
`Modules/Media/app/Support/TemporaryUploadPathGenerator.php`, whose `implements PathGenerator`
line was already commented out (along with the `use` imports for the interface and for
`Spatie\MediaLibrary\Support\PathGenerator\PathGenerator`). A repo-wide grep for `PathGenerator`
across `Modules/` confirmed no other class implements it and nothing binds it in a service
container/provider.

## Why this is yagni

Per ponytail YAGNI rung: an interface earns its keep only when there are two or more concrete
consumers sharing a boundary. Here there was exactly zero live implementers (the one candidate
implementation had already opted out, in code, via the commented `implements`). The interface
was dead weight: an abstraction with no callers and no swap-need.

## Fix

Deleted `Modules/Media/app/Contracts/PathGenerator.php`. No replacement introduced.
`TemporaryUploadPathGenerator.php` left as-is (still works standalone, commented-out lines
left in place as a minimal-diff choice).

## Verification

## Ponytail audit — Media

_Fonte: `wiki/concepts/ponytail-audit.md`_

# Ponytail audit — Media

**Delta modulo only here.** Ranked list, gate e remediation globale negli hub progetto.

- [Hub audit](../../../../../../docs/audit/ponytail-audit.md)
- [Remediation](../../../../../../docs/project/ponytail-audit-remediation.md)
- [Findings Media](../../ponytail-audit-over-engineering.md)

Aggiornare solo finding e stato specifici di questo modulo.
