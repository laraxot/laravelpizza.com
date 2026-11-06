---
title: Brainstorming: wave Services verso Spatie Queueable Actions
type: bmad-brainstorming
status: synthesized
module: Xot
track: bmad-method
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, brainstorming, services, queueable-action, filament-blueprint]
qmd: "brainstorming services to actions spatie queueable perche 5 whys scamper reverse swot filament cartelle app services zero"
related:
  - ../bmad-brainstorming.md
  - ./filament-blueprint.md
  - ./planning-services-to-actions-zero-folders.md
  - ./services-to-queueable-actions-brainstorming.md
  - ./services-to-queueable-actions-architecture.md
  - ./services-to-queueable-actions-filament-blueprint.md
  - ./services-to-queueable-actions-census.md
  - ./services-to-queueable-actions-objective.md
  - ../stories/services-to-actions-global-wave.story.md
  - ../../../Geo/docs/stories/services-zombie-delete-wave3.story.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../../../../../bashscripts/docs/prompts/25-services-to-actions.md
  - ../../../../../bashscripts/ai/wiki/memories/services-riapparsi-sono-copie-di-actions-esistenti.md
---

# Domanda guida

Come garantire **zero** cartelle `laravel/Modules/<modulo>/app/Services/` (non solo
zero `*Service.php`) senza duplicare Actions gia' esistenti e senza rompere
Filament / tenancy / queue?

## Perche' (religione + senso)

La regola [no-services-rule](../../../../../bashscripts/ai/wiki/rules/no-services-rule.md)
non e' estetismo:

1. un Service diventa god-class (create/update/notify/export…);
2. non e' accodabile in modo uniforme;
3. nasconde i confini di dominio;
4. **la cartella stessa** e' un segnale di debito: anche vuota o con solo adapter
   invita il merge a riesumare classi e confonde il ratchet CI.

Una **Spatie QueueableAction** con `execute()`:

1. **un caso d'uso = una classe** (SRP);
2. **stesso codice sync o in coda** (`->onQueue()` / `execute()`);
3. **testabile** senza mock di un bagaglio di metodi;
4. **tipizzabile** (parametri/return concreti o Spatie Data), amica di PHPStan;
5. **chiamabile da Filament** senza ingrassare form hooks
   ([filament-blueprint](./services-to-queueable-actions-filament-blueprint.md)).

Adapter / translator Laravel / registry / stream HTTP **non** sono use-case:
vivono in `Adapters/`, `Contracts/`, `Support/`, `Infrastructure/`: **mai** sotto
`app/Services/`.

## Inventario misurato (disco vivo, 2026-10-20)

Gate:

```bash
find Modules -type d -path '*/app/Services' ! -path '*/vendor/*' ! -path '*/tests/*'
find Modules -path '*/app/Services/*.php' ! -path '*/vendor/*' ! -path '*/tests/*'
find Modules -path '*/app/Actions/*Action.php' | wc -l
```

| Esito | Dettaglio |
|-------|-----------|
| Cartelle `Modules/*/app/Services` | **0** |
| Cartelle `Themes/*/app|…/Services` | **0** |
| `*.php` sotto `app/Services` | **0** |
| `use Modules\…\Services\` prod | **0** |
| Actions | **~770** sotto `Modules/*/app/Actions` (sera); ~682 mid-giorno |
| Mid-sessione (~12:40) | 8 dirs + 5 Geo PHP riesumati; **0** `use Modules\Geo\Services\`; match = commenti «Sostituisce…» |
| Post-cleanup + sera | dirs=0; allowlist ratchet = **[]**; `NoServicesTest` **3 PASS** |
| Falsi positivi | `TermsOfService` Livewire; `*/tests/Unit/Services` (fuori gate `app/`) |
| PHPStan | `analyse Modules --memory-limit=2G` → **OK No errors** |

Insight: la wave non e' «convertire N Service»; e' **delete-or-retarget di
riesumazioni merge** + **ratchet sulla directory**. Planning maintain:
[planning-services-to-actions-zero-folders.md](./planning-services-to-actions-zero-folders.md).

## 5 Whys

1. Perche' riappaiono Services? → Merge/`laraxot/dev` riporta path cancellati localmente.
2. Perche' il merge li riporta? → Upstream e lane parallele non condividono ancora la religione no-services.
3. Perche' rischiamo di «convertire» di nuovo? → Istinto Service→nuova Action senza cercare la gemella.
4. Perche' quello e' pericoloso? → Duplicati, bug copiati (`exit()` in coda), Filament con due API.
5. Causa radice operativa → **Procedura delete-or-retarget** + **gate sulla cartella** (`archAllowedServicesDirs` vuota).

## Starbursting

| | |
|---|---|
| **Chi** | Coordinatore Xot + lane Geo (residuo tipico) |
| **Cosa** | Zero dirs `app/Services`; caller su Actions; Filament senza Service |
| **Quando** | Dopo PHPStan calm; boy scout permanente se merge riesuma |
| **Dove** | `Modules/<M>/app/Actions`, story, blueprint Filament |
| **Perche'** | Confini, coda, PHPStan, no god-class, CI ratchet |
| **Come** | Prompt [25](../../../../../bashscripts/docs/prompts/25-services-to-actions.md) + [architecture](./services-to-queueable-actions-architecture.md) |

## SCAMPER (sintesi)

- **Substitute**: metodo Service → Action verbale esistente o nuova `*Action::execute()`.
- **Combine**: vietato fondere use case diversi in una Action «manager».
- **Adapt**: Filament → `app(Action::class)->execute()`; Facade Geo puo' restare come *nome* di confine se accessor punta ad Action.
- **Modify**: `execute()` sync di default; `dispatch()` solo contratto asincrono esplicito.
- **Put to other uses**: no shim Service a lungo termine.
- **Eliminate**: 0 caller produzione + Action presente → DELETE (non relocate).
- **Reverse**: partire dai canary Filament/tenancy, poi zombie.

## Reverse brainstorming (come fallire)

- Convertire senza `rg` Action gemella → doppio codice.
- Lasciare `app/Services/` vuota «per dopo» → merge riesuma file.
- Tenere Geo in `archAllowedServicesDirs` dopo delete → Pest arch fallisce asimmetrico.
- Confondere `RouteService` Xot con `RouteServiceProvider`.
- Logica in Filament `afterStateUpdated` invece che Action.
- Accodare Action con `exit()` / handle aperti.
- Dichiarare done sulla story senza rileggere il disco.

## SWOT

| | |
|---|---|
| **S** | ~770 Actions; story per-modulo; blueprint Filament; `NoServicesTest` verde |
| **W** | Merge riesuma; sessioni parallele riscrivono gli stessi path |
| **O** | Gate dirs=0 stabile; boy scout delete-again automatico |
| **T** | OOM PHPStan (SIGKILL); lock caldi; docs che citano ancora API Service |

## Insight azionabili (top 5)

1. **Religione = cartella assente**, non solo file assenti.
2. **Geo mid-sessione era zombie comment-only**: Actions gia' sostituiscono; delete, non convert.
3. **Ratchet**: `NoServicesTest` (directory + namespace + `use`); allowlist `[]`.
4. **Filament blueprint** e' vincolo permanente: Resource/Page/Widget → Actions.
5. **PHPStan Modules a zero non chiude la wave**: continua boy scout no-services senza conferma.

## Rischi

- Nuovo merge da `laraxot/dev` riesuma i cinque Geo.
- Qualcuno «protegge» Geo in allowlist invece di delete-again.
- Docs storiche che documentano ancora `GeoService` come API pubblica.

## Next BMAD

Planning maintain: [planning-services-to-actions-zero-folders.md](./planning-services-to-actions-zero-folders.md).
Story: [services-to-actions-global-wave.story.md](../stories/services-to-actions-global-wave.story.md)
- **done** su acceptance dirs=0; se merge riesuma Geo →
[services-zombie-delete-wave3](../../../Geo/docs/stories/services-zombie-delete-wave3.story.md)
come delete-again (mai conversione di massa).
