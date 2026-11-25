---
id: rating-schema-form-dai-rating
slug: schema-form-dai-rating
title: "Da riga di rating a campo di form: il fondamento prima del metodo"
description: "Perché getRatingsFormSchema() appartiene al trait, cosa non deve portarci dentro, e la domanda che l'estrazione costringe a chiudere: qual è il contratto fra una riga di ratings e il campo che diventa."
type: concept
document_type: concept
category: architecture
status: active
version: 1.0.0
language: it-IT
module: Rating
scope: [modules]
audience: [ai-agents, developers, architects]
tags: [ratings, form-schema, hasratingstrait, caller, contratto, label, is-readonly]
created: 2026-09-09
updated: 2026-09-09
qmd: "schema form dai rating getRatingsFormSchema HasRatingsTrait caller contratto riga ratings campo form is_readonly rule label da database titolo dispatch Str studly money"
issues:
  # DA CREARE: nessun numero inventato.
  - "https://github.com/provtv/module_rating_fila5/issues/"
discussions:
  - "https://github.com/provtv/module_rating_fila5/discussions/"
related:
  - ../../workflows/estrarre-uno-schema-filament-condiviso.md
  - ../../stories/8.18.due-model-type-punteggio-invisibile.story.md
  - ../../stories/5.90.resolve-rating-class-guardia-e-rationale.story.md
  - ../../../../IndennitaResponsabilita/docs/stories/18.49.campi-calcolati-riconosciuti-dal-titolo.story.md
  - ../../../../Xot/docs/stories/5.91.docs-moduli-e-temi-debito-misurato.story.md
maintainer: Laraxot
license: project-internal
---

# Da riga di rating a campo di form

## Fondamento: perché, logica, scopo, filosofia, politica, religione, zen

### Perché

Perché `ratings` non è una tabella di configurazione: è **il questionario**. Ogni riga è una
domanda che qualcuno dovrà rispondere in un form, e oggi la traduzione da riga a campo esiste
in un punto solo: `CompilaIndennitaResponsabilita::getRatingsSchema()`, 60 righe dentro una
pagina di un modulo foglia.

Il modulo `Rating` possiede le righe, le relazioni, la regola di validazione e il flag
`is_readonly`. Possiede tutto ciò che serve a costruire il campo, e non lo costruisce. Chi
possiede il dato e non ne possiede la forma costringe ogni consumatore a reinventarla: e a
reinventarla **diversa**.

### Logica

Il trait sa **cosa** ogni riga è: modificabile o calcolata, con quale regola, con quale
etichetta. Non sa **come** quel campo si comporta nel dominio di chi lo ospita: se è denaro,
quale funzione lo ricalcola, quante colonne occupa.

Da qui la divisione, che è la sola non arbitraria:

| | chi decide |
|---|---|
| che un rating diventa un campo | **il trait** |
| che i `is_readonly` sono in sola lettura | **il trait** |
| il nome del campo, la regola di validazione, la reattività | **il trait** |
| hydrate/sync pivot value+note (altro = `''`) | **il trait** (5.147) |
| stringa etichetta form (`formFieldLabel`) + decorazione Fieldset/Field di default | **trait + concern Filament** (5.149): l’host può ancora override |
| che «importo annuale» si mostra in euro | **l'host** |
| quale metodo ricalcola quel campo | **l'host** |
| la soglia minima di criteri compilati | **l'host** |

Il `$caller` è il canale di quella seconda colonna. Non è un espediente: è il confine.

### Scopo

Che il secondo modulo che deve compilare dei rating non riscriva sessanta righe, e che il
terzo non le riscriva **diverse dal secondo**.

### Filosofia

Un componente riutilizzabile porta la sua logica: è già scritto nel repo, in
`filament-reusable-component-owns-visibility`. Ma porta la logica **generale**. La logica
**particolare** non la indovina: la chiede.

Il modo in cui la chiede è la differenza fra un'astrazione e una trappola. Chiederla per
interfaccia o per closure è chiedere. Dedurla dal testo dell'etichetta è indovinare.

### Politica

`Rating` è consumato da **sei** moduli. Ogni riga che entra qui è un impegno verso tutti e
sei, e nessuno dei sei l'ha chiesta. Perciò entra solo ciò che è vero per tutti; il resto si
chiede al chiamante.

Il corollario scomodo: **un difetto estratto nel trait smette di essere un difetto locale e
diventa la piattaforma.** Estrarre è il momento in cui i difetti si promuovono.

### Religione

Tre divieti non negoziabili, e questa estrazione li tocca tutti e tre.

1. **Mai `->label()`.** La regola è `no-filament-labels`, e dice «SENZA ECCEZIONI». La pagina
   attuale ne ha **otto**.
2. **Mai dedurre il comportamento dal testo.** «Se l'etichetta contiene *Importo* allora è
   denaro» funziona finché qualcuno non traduce l'etichetta.
3. **Mai un `if` sulla categoria dentro un calcolo**: la differenza sta nei dati, non in
   cinque rami di logica.

### Zen

Il metodo giusto è quello che, guardandolo, non fa venire voglia di chiedere *«e se il titolo
cambia?»*.

---

## Il contratto oggi, e dov'è scritto

| Cosa decide | Dove sta | Forma |
|---|---|---|
| modificabile o calcolato | `ratings.is_readonly` | **colonna** ✅ |
| regola di validazione | `ratings.rule` → `RuleEnum` | **colonna** ✅ |
| anno e popolazione | `ratings.extra_attributes` | **colonna** ✅ |
| etichetta | `ratings.txt ?? ratings.title` | **colonna**, ma passata a `->label()` ⚠️ |
| **è denaro** | `Str::contains($label, 'Importo')` | **testo dell'etichetta** ❌ |
| **chi lo ricalcola** | `'get'.Str::studly($rating->title)` | **testo del titolo** ❌ |

Le prime quattro righe sono un contratto. Le ultime due sono una convenzione nascosta in una
stringa italiana. Ed è già una story aperta:
[`IndennitaResponsabilita/18.49`](../../../../IndennitaResponsabilita/docs/stories/0059-campi-calcolati-riconosciuti-dal-titolo.story.md)
- «i campi calcolati si riconoscono dal titolo, e il flag c'è già».

## La tensione che l'estrazione costringe a chiudere: l'etichetta

`no-filament-labels` vieta `->label()` senza eccezioni: l'etichetta viene dai file di lingua,
risolti dal nome del campo. Ma qui il nome del campo è `ratings.{id}.pivot.value`: un id che
cambia per anno e per modulo: e l'etichetta vive in una **riga di database**.

Le due cose non possono essere entrambe vere così come sono. Tre uscite:

1. **Il rating diventa traducibile per `slug`.** `BaseRating` usa già `Spatie\Sluggable\HasSlug`
   e la colonna `slug` esiste. La chiave diventa `rating::values.<slug>.label`, esattamente come
   `RuleEnum` fa oggi con `lang/it/rule_enum.php`. Il precedente è nel modulo stesso.
2. **La regola guadagna un'eccezione dichiarata** per i campi la cui etichetta è un dato, non
   una costante. Oggi non ce l'ha, e otto violazioni la aggirano in silenzio.
3. **Il testo resta nel database ed è quello il canone**, e la regola va corretta perché
   afferma un assoluto che il dominio non rispetta.

Non è una scelta tecnica: è quale delle due fonti: file di lingua o database: è la verità
per un questionario che cambia ogni anno. Va decisa, non dedotta.

> Nota su come questa domanda è rimasta aperta finora: la regola `no-filament-labels` in
> `bashscripts/ai/wiki/rules/` è **lunga cinque righe e rimanda a se stessa**: il bridge e il
> canone sono lo stesso file via symlink. Il contenuto vero sta in
> `rules/filament/no-filament-labels.md`. Una regola che non si può leggere non si può
> applicare, ed è il motivo per cui otto `->label()` convivono con un «divieto assoluto».

## Quante volte serve davvero: misurato

Tredici pagine `Compila*` in cinque moduli. Ma:

| | |
|---|---|
| costruiscono un form di rating con lo schema Filament | **1**: `CompilaIndennitaResponsabilita` (427 righe) |
| sottoclassi thin di quella | 5: le `CompilaScheda*` STI, 18 righe l'una |
| pagine **Blade**, non schema Filament | 2: `Progressioni/CompilaScheda` (212), `IndennitaCondizioniLavoro/CompilaCondizioniLavoro` (206): usano `getViewData()` e `form_data` |
| thin o action | 5 |

**Oggi l'occorrenza è una.** La regola del repo dice di non astrarre sotto le tre.

Perciò questa estrazione **non è deduplicazione**, ed è onesto dirlo: è la posa di un
contratto prima che nascano la seconda e la terza occorrenza: che nasceranno, perché
Progressioni e IndennitaCondizioniLavoro fanno la stessa cosa in Blade e prima o poi
migreranno.

La conseguenza pratica: siccome non stiamo togliendo duplicazione, **l'unico guadagno è il
contratto**. Se il contratto estratto porta con sé le due deduzioni da stringa, l'operazione è
in perdita.

## Collegamenti

- [Workflow: estrarre uno schema Filament condiviso](../../workflows/estrarre-uno-schema-filament-condiviso.md)
- [18.49: i campi calcolati si riconoscono dal titolo](../../../../IndennitaResponsabilita/docs/stories/0059-campi-calcolati-riconosciuti-dal-titolo.story.md)
- [5.90: resolveRatingClass e il meccanismo della piattaforma](../../stories/0046-resolve-rating-class-guardia-e-rationale.story.md)
