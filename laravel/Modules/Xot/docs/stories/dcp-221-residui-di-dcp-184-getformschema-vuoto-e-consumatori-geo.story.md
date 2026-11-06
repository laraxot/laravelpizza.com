---
id: dcp-221
title: "DCP-221: residui di DCP-184, getFormSchema() vuoto e consumatori Geo"
type: story
epic: dc-parity-v2
status: ready-for-dev
priority: P2
owner: module:Xot
module: Xot
created: 2026-10-15
updated: 2026-10-15
qmd: "XotBaseResource getFormSchema final return vuoto AddressField AddressesField AddressForm getFormSchemaOld docblock property duplicati ide-helper"
related: [dcp-184, dcp-185]
tags: [xot, filament, form, debito]
---

# DCP-221: residui di DCP-184

## Fase BMAD
Plan. DCP-184 ha chiuso l'emergenza (app a 500 per `getFormSchemaOld()` diventato `final`) e la migrazione dei nove override. Restano tre cose che quella story nominava come «non verificate» o «non mie». Questa raccoglie cosa fare e una decisione che spetta a chi ha deciso il cambio di base.

## Stato misurato (2026-10-15)
1. **Override rimasti: nessuno.** `rg 'function getFormSchemaOld' Modules Themes` trova solo la base `XotBaseResource`.
2. **La base.** `XotBaseResource` ha `getFormSchema()` e `getFormSchemaOld()` entrambe `final` e che restituiscono `[]` (righe 131-151). Il commento nel codice dice «DEVE ESSERE FINAL !!»: la forma e' una scelta esplicita, non una dimenticanza. Il vero schema vive in `Resource\Schemas\<Model>Form::getFormSchema()` (metodo di istanza, ereditato da `XotBaseResourceForm`).
3. **Consumatori che ricevono `[]`.** `Modules/Geo/app/Filament/Forms/Components/AddressField.php:41` e `AddressesField.php:98-100` leggono `app(AddressResource::class)->getFormSchema()`, poi tolgono o rinominano chiavi (`name`, `is_primary`): con `[]` i campi nascono **senza input**. `rg` non trova nessun `AddressField::make` o `AddressesField::make` fuori dai due file: oggi nessuno li usa, il difetto e' latente.
4. **Docblock `@property` ripetuti** in cinque modelli (conteggio delle righe `@property ... $id`): `Gdpr/Models/Treatment` 7, `Gdpr/Models/Event` 7, `Job/Models/JobManager` 2, `Gdpr/Models/Profile` 2, `Gdpr/Models/Consent` 2. Solo estetico. La causa non e' stata letta nel generatore: ipotesi non provata, `ide-helper:models` rilanciato senza ripulire il blocco precedente.

## Cose da fare
- [ ] **T1.** Scrivere un test su `AddressField` e `AddressesField` che prova che lo schema non e' vuoto (rosso oggi). Poi correggere secondo la decisione D221-1.
- [ ] **T2.** Ripulire i docblock dei cinque modelli a mano (lasciare un solo blocco). Non rilanciare `ide-helper:models` sull'intero progetto: riscrive tutti i modelli di tutti i moduli, fuori da questa story.
- [ ] **T3.** Aggiornare la tabella di stato di DCP-184 (9 override tutti migrati) con un rimando a questa story, in coda e con data.

## Decisioni da prendere
| ID | Chi decide | Domanda | Opzioni | Proposta |
|---|---|---|---|---|
| D221-1 | Titolare tecnico (ha scritto «DEVE ESSERE FINAL !!») | Come si rimettono gli input nei due campi Geo | A) i consumatori usano direttamente `app(AddressForm::class)->getFormSchema()`; B) la base delega `getFormSchema()` a `app(static::getFormClass())->getFormSchema()` | **A**: coerente col commento della base (la classe `*Form` e' l'unico posto), 2 righe in 2 file, e non rende di nuovo utile il metodo che si e' voluto svuotare. B sistema anche chiamanti futuri ma contraddice l'intento |
| D221-2 | Titolare tecnico | Tenere o togliere `getFormSchemaOld()` ora che nessun override esiste | tenere inerte; rimuovere | **Tenere.** Un modulo vive in piu' progetti (regola dei nomi agnostici): un altro progetto con un override scatenerebbe lo stesso fatal. Rimuovere solo dopo aver contato gli override altrove: non misurabile da qui |

## Criteri di accettazione
1. Il test di T1 e' verde con la soluzione scelta in D221-1.
2. `rg -c '@property .*\$id$'` vale 1 nei cinque modelli.
3. `php -l` e PHPStan puliti sui file toccati.

## Non verificato
Nessun uso reale di `AddressField` (non esiste); il comportamento in altri progetti che usano Xot; la causa dei docblock duplicati.

## Nota di verifica (2026-10-20, progetto Quaeris)
D221-2 si e' verificata come previsto. Dopo il pull dei sottomoduli nel progetto Quaeris, `./vendor/bin/phpstan analyse Modules` si fermava su `Cannot override final method XotBaseResource::getFormSchemaOld()`: sei override, mai migrati perche' il cambio di base era stato fatto e migrato in un altro progetto. Migrati qui con lo stesso metodo di DCP-184 (contenuto spostato nella `*Form`, poi override tolto):
- Chart: [getformschemaold-final-chart-resources](../../../Chart/docs/stories/getformschemaold-final-chart-resources.story.md) (`ChartResource`, `MixedChartResource`).
- Quaeris: [getformschemaold-final-quaeris-resources](../../../Quaeris/docs/stories/getformschemaold-final-quaeris-resources.story.md) (`ContactResource`, `QuestionChartResource`, `PdfStyleResource`, `CustomerResource`).
Per chi cambia una firma della base: il conteggio degli override va fatto in ogni progetto che monta Xot, non solo in quello dove si lavora.
