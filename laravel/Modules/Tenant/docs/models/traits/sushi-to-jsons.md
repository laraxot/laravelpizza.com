---
issues:
  - "https://github.com/provtv/module_tenant_fila5/issues/18"
discussions:
  - "https://github.com/provtv/module_tenant_fila5/discussions/19"
title: "Sushi To Jsons"
module: "Tenant"
type: concept
tags: [sushi, json, multi-tenancy, tenant-isolation]
created: 2026-07-14
updated: 2026-10-28
qmd: "sushi to jsons tenant json rows nested paths overrides isolation"
related:
  - "../../bmad/purpose.md"
  - "../../bmad/sushi-model-pitfalls.md"
status: active
---

# Sushi To Jsons

> Questo trait espone i file JSON del tenant attivo come righe Sushi; il percorso risolto dal tenant è parte del contratto di isolamento, non un dettaglio di ricerca file.

## Scopo

`SushiToJsons` serve ai modelli di configurazione che devono comportarsi come tabelle
Eloquent senza introdurre migrazioni o dati condivisi. `GetTenantFilePathAction` risolve
la directory `database/content/<table>` del tenant corrente; il trait legge ricorsivamente
i JSON presenti lì e li mappa secondo lo schema del modello.

La responsabilità di `collectRowsFromJsonFiles()` è precisa:

1. risolvere una sola radice appartenente al tenant attivo;
2. raccogliere tutti i JSON anche nelle sottocartelle;
3. trasformare ogni file in una riga;
4. prefissare `id` e `slug` delle righe annidate con il percorso logico;
5. restituire le righe senza fondere sorgenti esterne al tenant.

## Errore corretto: confondere sorgenti con livelli di configurazione

Una versione precedente cercava di costruire una lista di sorgenti aggiungendo directory
dei moduli e dei temi alla directory tenant. Questo era concettualmente errato:

- `base_path('Modules')` e i temi non rappresentano il tenant corrente;
- una configurazione baseline non è automaticamente una riga del tenant;
- la fusione cambiava la cardinalità dei risultati e la precedenza degli override;
- un `id` prefissato dalla sottocartella non può essere usato da solo per dedurre
  l'identità logica dello slug;
- il risultato poteva contenere dati di configurazione di un altro contesto, senza
  produrre un errore evidente.

La correzione mantiene la raccolta ancorata al path restituito da
`GetTenantFilePathAction` e usa `File::allFiles()` per includere le sottocartelle.
Questo protegge sia il comportamento Sushi sia la promessa fondamentale di Tenant:
un tenant non deve vedere la configurazione di un altro tenant.

## Identità delle righe annidate

Per un file come `database/content/pages/tickets/index.json`, `id` e `slug` vengono
esposti con il prefisso logico `tickets.`. Il prefisso evita collisioni tra file omonimi
in sottocartelle diverse. Due file con lo stesso slug nella stessa cartella restano
invece due righe: è una configurazione ambigua che deve essere segnalata dalla
validazione applicativa, non nascosta durante il caricamento.

## Regole operative

- Non usare `base_path()` per leggere o scrivere dati del tenant.
- Non aggiungere directory di moduli o temi alla raccolta del trait senza una decisione
  esplicita sul modello di ereditarietà della configurazione.
- Non usare `dd`, `ddd` o `dddx` nel percorso normale di caricamento: un JSON invalido
  deve produrre un errore diagnosticabile, non interrompere silenziosamente una richiesta.
- Mantenere `getRows()` e `getSushiRows()` come delega unica a
  `collectRowsFromJsonFiles()`; evitare copie del comportamento nei modelli.
- Coprire almeno JSON piatto, JSON in sottocartella, file non JSON, schema assente e
  isolamento tra tenant.

## Riferimenti

- `app/Models/Traits/SushiToJsons.php`
- `app/Actions/Config/GetTenantFilePathAction.php`
- `tests/Unit/SushiToJsonTraitPestTest.php`
- `tests/Integration/Traits/SushiToJsonTraitIntegrationTest.php`

