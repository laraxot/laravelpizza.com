---
<<<<<<< .merge_file_iBnYyA
title: "Decision log — UI"
type: decision-log
status: review
bmad_status: active
scope: ui-docs
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_G0RLBy
bmad_status: active
scope: ui-docs
=======
>>>>>>> .merge_file_yhNFVS
>>>>>>> laraxot/dev
title: "Decision log — UI"
type: decision-log
status: review
bmad_status: active
scope: ui-docs
>>>>>>> .merge_file_wbf0dR
updated: 2026-11-16
module: UI
qmd: "decision log ADR UI audit policy confini"
---

# Decision log — UI

## Audit source-first 2026-11-16

Decisioni proposte dall'audit. Formato: ADR breve (stato, impatto, decisione, perché, evidenza).

### ADR-UI-01 — Dashboard UI senza dati finti

- **Data:** 2026-11-16
- **Stato:** PROPOSTA (da approvare dal titolare del modulo; nessun codice cambiato dall'audit)
- **Impatto:** Medio
- **Decisione:** La dashboard del pannello `ui::admin` mostra solo widget reali; `TestWidget`/`TestChartWidget` passano a `tests/Fixtures`.
- **Perché:** Un admin non deve leggere metriche inventate; UI è il vocabolario condiviso, non una vetrina.
- **Evidenza:** [audits/ui-audit.md](./audits/ui-audit.md)

### ADR-UI-02 — Nessun test per modelli inesistenti

- **Data:** 2026-11-16
- **Stato:** PROPOSTA (da approvare dal titolare del modulo; nessun codice cambiato dall'audit)
- **Impatto:** Basso
- **Decisione:** I 3 test su Asset/Component/Theme si cancellano finché il modello non esiste (regola `no-phpstan-probe-models`); niente `@phpstan-ignore` per tacere PHPStan.
- **Perché:** Il rapporto test/app non deve contare test che si auto-saltano.
- **Evidenza:** [audits/ui-audit.md](./audits/ui-audit.md)

### ADR-UI-03 — `UiBasePolicy` estende `XotBasePolicy`

- **Data:** 2026-11-16
- **Stato:** PROPOSTA (da approvare dal titolare del modulo; nessun codice cambiato dall'audit)
- **Impatto:** Medio
- **Decisione:** Prima di creare una Resource UI la base policy eredita `DeniesUndeclaredFilamentAbilities`.
- **Perché:** Filament concede le abilità non dichiarate: senza base la prima Resource sarebbe aperta a tutti.
- **Evidenza:** [audits/ui-audit.md](./audits/ui-audit.md)



## 2026-11-16 — Filament Styles/Scripts: owner UI, non Cms

- **Decisione:** in PTVX l'obbligo Filament 5 `@filamentStyles` / `@filamentScripts`
  vive nei layout UI/User, non in `Modules/Cms/.../head|foot` (modulo assente).
- **Perché:** topologia portfolio (HR panel-only); rsync Cms già revertito.
- **Fonte:** https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout


## 2026-11-16 — notifications SENZA @auth

- **Decisione:** `@livewire('notifications')` nudo; mai `@auth`/`@endauth`.
- **Fonte:** Filament 5 configuring-your-layout; memoria portfolio filament5-layout-contract.
- **Owner PTVX:** UI/User layouts (Cms assente).
