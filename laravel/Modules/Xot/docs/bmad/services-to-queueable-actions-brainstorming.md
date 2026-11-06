---
title: "BMAD brainstorming: Services to Queueable Actions"
type: bmad-brainstorming
status: synthesized
module: Xot
track: bmad-method
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, brainstorming, scamper, reverse-brainstorming, queueable-actions]
qmd: "brainstorm services actions queueable scamper rischi adapter use case cartella zero"
related:
  - ./services-to-queueable-actions-objective.md
  - ./services-to-queueable-actions-architecture.md
  - ./brainstorming-services-to-actions-wave.md
  - ./services-to-queueable-actions-filament-blueprint.md
---

# Sintesi

Il problema non e' il suffisso `Service`: e' la sovrapposizione tra use-case gia'
presenti in Actions, adapter/framework, utility e codice morto riesumato dal merge.
**Stato vivo (2026-10-20 sera):** `Modules/*/app/Services` = **0 directory**,
`*.php` sotto quel path = **0**, Actions ≈ **770**; campione `laraxot/dev` (Xot,
Fixcity, Notify, User, Geo, Tenant) = **0 file** in `app/Services/`. La cartella
non deve tornare: assenza fisica = **ratchet anti-merge**, non solo convenzione.

Wave report operativo: [brainstorming-services-to-actions-wave.md](./brainstorming-services-to-actions-wave.md).


## Religione: cartella assente (perche')

Un use-case applicativo ha **un** ingresso (`execute()`), tipi veri, e puo' essere
accodato (`QueueableAction`) senza trascinare HTTP/Filament. Un `Service` e' un
contenitore di metodi: attira logica, duplica contratti, e il merge di `laraxot/dev`
lo riesuma. La directory `Modules/*/app/Services` a **zero** (anche vuota vietata)
e' il ratchet: se ricompare, e' regressione, non "lavoro in corso".

Filament: Resource/Widget chiamano Actions; mai `app(SomethingService::class)`.
Vedi [services-to-queueable-actions-filament-blueprint.md](./services-to-queueable-actions-filament-blueprint.md).

## 5 Whys: perche' Action e non Service (religione operativa)

1. **Perche' eliminare i Service applicativi?** Perche' ogni use-case deve essere
   **una** Action queueable tipizzata (`execute()` / `dispatch()`), non un metodo
   in un contenitore senza confini.
2. **Perche' il contenitore Service e' il problema?** Perche' `*Service` invita a
   accumulare orchestrazione, I/O, adapter e utility nello stesso namespace: nessun
   confine per use-case, difficile testare e accodare in modo esplicito.
3. **Perche' duplicare Actions + Services e' peggio del solo Service?** Perche'
   nascono due contratti, due suite di test e caller che divergono (Filament sync vs
   job async) fino al prossimo merge.
4. **Perche' queueizzare tutto non basta?** Perche' adapter, letture Filament e
   driver sincroni **non** devono diventare pseudo-Actions: vanno in `Adapters` /
   `Infrastructure`; la coda resta per orchestrazione con payload serializzabile.
5. **Perche' la cartella `app/Services` assente e' decisione, non dettaglio?**
   Perche' un merge che riesuma file e' visibile subito (`find …/app/Services` ≠ 0);
   **delete-again** + ratchet arch (`archAllowedServicesDirs()` = `[]`) impedisce di
   normalizzare di nuovo il layer Service come scorciatoia post-merge.

**Corollario:** `MunicipalService` / `Service` in Sixteen sono **modelli dominio**,
non il layer rimosso. Residui Blade (es. hero TwentyOne + `PredictService`) si
correggono con **props** e Actions del modulo owner, mai reintroducendo `app/Services`.

## SCAMPER: idee selezionate

| Leva | Decisione | Impatto | Fattibilita' |
|---|---|---:|---:|
| Substitute | Riutilizzare Actions esistenti prima di crearne altre | Alto | Alta |
| Combine | Spezzare i god-service per use-case, non per classe originale | Alto | Media |
| Adapt | Adapter/driver sincroni fuori da `Services/`; queue solo orchestrazione | Alto | Alta |
| Modify | `execute()` sincrono; `dispatch()` scelta del caller | Alto | Alta |
| Eliminate | Wrapper morti e duplicati dopo verifica caller; **rmdir Services** | Alto | Alta |
| Rearrange | Wave: duplicati → I/O esterno → framework → residui → ratchet dirs | Alto | Alta |

## Reverse brainstorming: modi per rompere la migrazione

- convertire ogni `*Service` senza leggere i caller;
- lasciare `app/Services/` vuota «temporaneamente»;
- passare Request, Closure, stream o modelli non necessari nella coda;
- dispatchare prima del commit (`after_commit=false` di default);
- rendere asincrone letture usate direttamente da Filament;
- spostare driver Mail/SMS, translator e streaming in Actions pseudo-servizio;
- lasciare vecchi caller attivi (invii duplicati);
- testare `Action::class` invece del wrapper `ActionJob` di Spatie;
- modificare insieme piu' moduli e perdere la provenienza delle regressioni;
- tenere una allowlist arch non vuota dopo il delete.

## Insight conclusivi

1. **Action = use-case/orchestrazione**, non sinonimo di ogni classe applicativa.
2. **Queueable non significa sempre asincrono**: stessa Action sync quando la UI
   richiede il risultato immediato.
3. **Adapter, registry, resolver, validator, strategy e stream restano confini
   tecnici** in `Adapters`/`Support`/`Infrastructure`: **mai** in `app/Services`.
4. La rimozione avviene solo dopo caller statici/dinamici, test, provider, config,
   route, Livewire e Filament verificati; poi **la directory sparisce**.

## Decisione proposta

Modello ibrido in [architecture](./services-to-queueable-actions-architecture.md):
delete-or-retarget prima di progettare nuove Actions; Filament segue
[services-to-queueable-actions-filament-blueprint](./services-to-queueable-actions-filament-blueprint.md).
