---
title: "SushiToJsons: sorgente delle righe"
type: concept
module: Tenant
tags: [tenant, sushi, json, multi-tenancy]
status: stable
---

# SushiToJsons: sorgente delle righe

`SushiToJsons::collectRowsFromJsonFiles()` costruisce le righe Sushi dai JSON del
tenant attivo. La sorgente canonica è il percorso restituito da
`GetTenantFilePathAction` per `database/content/<table>`; `File::allFiles()` include
anche le sottocartelle, necessarie per i contenuti organizzati per dominio.

## Errore corretto

Una precedente implementazione trattava il percorso tenant come overlay di JSON
provenienti da moduli e tema. Questo confondeva due responsabilità:

- Tenant risolve isolamento e contenuto effettivo dell'ente attivo.
- Moduli e temi forniscono codice e viste, non righe aggiuntive per la tabella
  Sushi del tenant.

La fusione produceva righe duplicate o collisioni di identità: un record con lo
stesso slug poteva essere letto da più sorgenti e un prefisso di sottocartella
poteva cambiare l'id, impedendo la sostituzione logica attesa. Il risultato era
un errore funzionale (query Sushi ambigua o dati duplicati), non un semplice
problema di tipizzazione.

## Regole operative

1. Risolvere una sola directory con `GetTenantFilePathAction`.
2. Leggere tutti i JSON ricorsivamente con `File::allFiles()`.
3. Ignorare i file non JSON o non convertibili in riga.
4. Applicare il prefisso alle chiavi `id` e `slug` quando il file è in una
   sottocartella.
5. Restituire le righe del tenant senza deduplicazione artificiale tra sorgenti.

Questa regola mantiene l'isolamento tenant e lascia alla validazione di dominio
la responsabilità di segnalare eventuali duplicati reali nella stessa sorgente.

6. Se la cartella della tabella non esiste per il tenant, la tabella è vuota (`return []`):
   `File::allFiles()` su una cartella assente lancia `DirectoryNotFoundException`. Il tenant
   `local/techplanner` ha solo `pages` e `sections`: senza guardia `Menu` e `PageContent`
   andrebbero in errore al primo accesso.
7. Nessun `dd`/`dddx` nel caricamento: un file non convertibile in riga si ignora (regola 3).

## Verificato (2026-10-28)

- Sorgenti extra della vecchia versione: l'unico JSON di baseline su disco è
  `Themes/Sixteen/config/local/fixcity/database/content/pages/home.json`, del tenant
  `fixcity`; qui `config/local` contiene solo `techplanner`, quindi per questo tenant i livelli
  leggevano zero file. I sintomi 500/503 su login e segnalazioni (commit `493af8b`) erano di
  Fixcity: il livello baseline è stato portato in un modulo condiviso per un bisogno di un altro progetto.
- La toppa per slug (`493af8b`) curava un effetto del livello stesso (id prefissato dalla
  sottocartella ≠ id piatto): la domanda giusta era se il livello dovesse esistere.
- Costo del livello: a ogni boot di ogni modello Sushi, `File::directories(base_path('Modules'))`
  (17 moduli) più due `isDirectory` per modulo.
- Sonda in sola lettura (nessun DB, metodo privato via reflection, tenant `local/techplanner`):
  `Page` 19 righe, `Section` 7, `Menu` 0, `PageContent` 0, nessuna eccezione.
- `phpstan analyse Modules/Tenant` → 0 errori.
- Storia: [sushi-json-single-tenant-source](../../stories/sushi-json-single-tenant-source.story.md).
