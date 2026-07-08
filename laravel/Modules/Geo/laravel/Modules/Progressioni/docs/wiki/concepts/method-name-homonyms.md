---
title: "censimento omonimi metodi — modulo Progressioni"
type: analysis
module: Progressioni
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Progressioni

> **128** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Progressioni)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 21 |
| `B_sigma_relationship_homonym` | 3 |
| `C_sigma_gg_business` | 2 |
| `D_field_metadata_contract` | 3 |
| `E_scheda_stack` | 43 |
| `F_trait_name_collision` | 4 |
| `G_module_local` | 23 |
| `H_cross_module_homonym` | 30 |

## Dettaglio

### `A_filament_framework` (21 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `B_sigma_relationship_homonym`

#### `peso` — relazione vs business (fix 2026-06-15)

- `ProgressioniRelationshipTrait::peso()` — `HasOne` verso `Pesi` (alias di `pesi()`)
- `Scheda::resolveCoeffPesoFromParams()` — ex `peso(array $params)`; non usare il nome `peso()` per logica non-relazione
- Vedi [scheda-peso-relationship-homonym.md](../../../scheda-peso-relationship-homonym.md)

#### `anag` — 7 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `asz00k1` — 2 classi

- `Progressioni` · `Scheda` · `Modules/Progressioni/app/Models/Scheda.php`

### `C_sigma_gg_business`

#### `ggInSedeTot` — 4 classi

- `Progressioni` · `Scheda` · `Modules/Progressioni/app/Models/Scheda.php`

#### `ggInSedeTotByArray` — 2 classi

- `Progressioni` · `Scheda` · `Modules/Progressioni/app/Models/Scheda.php`

### `D_field_metadata_contract`

#### `annFieldName` — 13 classi

- `Progressioni` · `SchedaCriteri` · `Modules/Progressioni/app/Models/SchedaCriteri.php`

#### `rangeFromField` — 13 classi

- `Progressioni` · `SchedaCriteri` · `Modules/Progressioni/app/Models/SchedaCriteri.php`

#### `rangeToField` — 13 classi

- `Progressioni` · `SchedaCriteri` · `Modules/Progressioni/app/Models/SchedaCriteri.php`

### `E_scheda_stack`

#### `toArray` — 39 classi

- `Progressioni` · `SchedaPdfNotification` · `Modules/Progressioni/app/Notifications/SchedaPdfNotification.php`
- `Progressioni` · `ProgressioniCollection` · `Modules/Progressioni/app/Transformers/ProgressioniCollection.php`
- `Progressioni` · `ProgressioniResource` · `Modules/Progressioni/app/Transformers/ProgressioniResource.php`

#### `before` — 14 classi

- `Progressioni` · `SchedaPolicy` · `Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

#### `populateFromLastYear` — 14 classi

- `Progressioni` · `AssenzePolicy` · `Modules/Progressioni/app/Models/Policies/AssenzePolicy.php`
- `Progressioni` · `CategoriaProproPolicy` · `Modules/Progressioni/app/Models/Policies/CategoriaProproPolicy.php`
- `Progressioni` · `CedDiffPolicy` · `Modules/Progressioni/app/Models/Policies/CedDiffPolicy.php`
- `Progressioni` · `CoeffPolicy` · `Modules/Progressioni/app/Models/Policies/CoeffPolicy.php`
- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriOptionPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriOptionPolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- … +6 occorrenze

#### `via` — 14 classi

- `Progressioni` · `SchedaPdfNotification` · `Modules/Progressioni/app/Notifications/SchedaPdfNotification.php`

#### `compila` — 13 classi

- `Progressioni` · `SchedaPolicy` · `Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

#### `toMail` — 10 classi

- `Progressioni` · `SchedaPdfNotification` · `Modules/Progressioni/app/Notifications/SchedaPdfNotification.php`

#### `validate` — 8 classi

- `Progressioni` · `Scheda` · `Modules/Progressioni/app/Models/Scheda.php`

#### `authorizeAccess` — 7 classi

- `Progressioni` · `CompilaScheda` · `Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

#### `criteriOptions` — 7 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `edit` — 7 classi

- `Progressioni` · `SchedaPolicy` · `Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

#### `back` — 6 classi

- `Progressioni` · `CompilaScheda` · `Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

#### `getActions` — 6 classi

- `Progressioni` · `CompilaScheda` · `Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

_… +31 metodi in questa categoria_

### `F_trait_name_collision`

#### `canSendEmail` — 2 classi

- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `criteriValutazione` — 2 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `msg` — 2 classi

- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `myLogs` — 2 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

### `G_module_local`

#### `checkGgCatecoPosfunNoAsz` — 4 classi

- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `Progressioni` · `ValutatorePolicy` · `Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

#### `findStabi0` — 4 classi

- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `Progressioni` · `ValutatorePolicy` · `Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

#### `syncProgressioniRepQua` — 4 classi

- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `Progressioni` · `ValutatorePolicy` · `Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

#### `trovaEsclusi` — 4 classi

- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `Progressioni` · `ValutatorePolicy` · `Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

#### `xlsProgressioni` — 4 classi

- `Progressioni` · `CriteriEsclusionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `Progressioni` · `CriteriPrecedenzaPolicy` · `Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `Progressioni` · `CriteriValutazionePolicy` · `Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `Progressioni` · `ValutatorePolicy` · `Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

#### `asz00fs` — 2 classi

- `Progressioni` · `Assenza` · `Modules/Progressioni/app/Models/Assenza.php`
- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `checkDisci` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `checkListaAszTipCodEsclusoSubito` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `checkListaPosiz` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `checkListaPropro` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `checkListaProproPosfun` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

#### `checkMinGgCatecoPosfunLavoratiInSede` — 2 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `Progressioni` · `trait:ProgressioniFunctionTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

_… +11 metodi in questa categoria_

### `H_cross_module_homonym`

#### `getColumns` — 7 classi

- `Progressioni` · `CedDiffImporter` · `Modules/Progressioni/app/Filament/Imports/CedDiffImporter.php`
- `Progressioni` · `CedDiffImport` · `Modules/Progressioni/app/Imports/CedDiffImport.php`

#### `getXlsFields` — 7 classi

- `Progressioni` · `ProgressioniResource` · `Modules/Progressioni/app/Filament/Resources/ProgressioniResource.php`

#### `collection` — 6 classi

- `Progressioni` · `CedDiffImport` · `Modules/Progressioni/app/Imports/CedDiffImport.php`

#### `mailInviate` — 6 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `mails` — 6 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `messages` — 5 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `populate` — 5 classi

- `Progressioni` · `ProgressioniPolicy` · `Modules/Progressioni/app/Models/Policies/ProgressioniPolicy.php`

#### `criteriEsclusione` — 4 classi

- `Progressioni` · `trait:ProgressioniRelationshipTrait` · `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

#### `panel` — 4 classi

- `Progressioni` · `AdminPanelProvider` · `Modules/Progressioni/app/Providers/Filament/AdminPanelProvider.php`

#### `schede` — 4 classi

- `Progressioni` · `CriteriEsclusione` · `Modules/Progressioni/app/Models/CriteriEsclusione.php`
- `Progressioni` · `MaxCatecoPosfunAnno` · `Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`
- `Progressioni` · `StabiDirigente` · `Modules/Progressioni/app/Models/StabiDirigente.php`
- `Progressioni` · `Valutatore` · `Modules/Progressioni/app/Models/Valutatore.php`

#### `benificiariProgressione` — 3 classi

- `Progressioni` · `StabiDirigente` · `Modules/Progressioni/app/Models/StabiDirigente.php`
- `Progressioni` · `Valutatore` · `Modules/Progressioni/app/Models/Valutatore.php`

#### `check` — 3 classi

- `Progressioni` · `TrovaEsclusiAction` · `Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

_… +18 metodi in questa categoria_



## Riflessioni Progressioni

Cluster `E_scheda_stack`: ereditarietà da `BaseScheda` e trait scheda — allineare a un solo trait accessor `getGg*`.
Verificare che i modelli scheda estendano la gerarchia documentata in Ptv/Sigma wiki.


## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
