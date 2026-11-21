---
title: "Media — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [media, purpose, allegati, conversioni, storage, public-path]
qmd: "media scopo modulo allegati conversioni temporary upload storage public html path prova documentale"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_media_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_media_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_media_fila5/discussions/"
---

# Media — perche' esiste

## Lo scopo in una frase

**Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili
nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## L'evidenza

- **49 Action** per soli 124 file PHP: e' il modulo con la densita' operativa piu' alta
  del progetto dopo Xot. Coerente: manipolare file e' fatto di molte operazioni piccole.
- `Media`, `MediaConvert`, `TemporaryUpload`.
- Zero Widget: lavora sotto le altre schermate.

`TemporaryUpload` merita attenzione: un file caricato in un form non ancora salvato
esiste **prima** dell'entita' a cui apparterra'. Gestire quel limbo — e ripulirlo — e'
un problema reale che il modello rende esplicito.

## Il vincolo che decide tutto: dove finiscono i file

In questo progetto `public_path()` e' **`public_html/`**, fratello di `laravel/`, non
`laravel/public/`. `App\Application::publicPath()` in `bootstrap/app.php` lo garantisce.

Sbagliarlo e' l'errore muto per eccellenza: i file si scrivono, i test passano, e il
**404 arriva solo dal browser in produzione**. Vale per `storage:link`, per il manifest
Vite e per ogni `asset()`. Guardia esistente:
`laravel/tests/Unit/PublicPathPointsToPublicHtmlTest.php`.

## Come raggiungerlo **meglio**

### 1. Gli allegati che sostengono un provvedimento non si cancellano

Un allegato che motiva un'esclusione o un'indennita' e' **prova**. La cancellazione
fisica distrugge la motivazione retroattivamente.

**Azione:** distinguere i media "di lavoro" (rigenerabili: anteprime, conversioni) dai
media "documentali" (unici). Per i secondi, solo cancellazione logica. Vale la regola
dei dati sacri.

### 2. `TemporaryUpload` va ripulito, con una regola dichiarata

I file caricati e mai confermati si accumulano. Senza una politica, crescono per anni.

**Azione:** scadenza esplicita (es. 24 ore) e un lavoro pianificato che la applichi —
registrando quanti file ha rimosso. Una pulizia silenziosa e una pulizia non eseguita
si assomigliano troppo.

### 3. Le conversioni vanno accodate e il fallimento deve essere visibile

`MediaConvert` genera derivati. Se una conversione fallisce, il sintomo tipico e'
un'anteprima mancante che nessuno collega alla causa.

**Azione:** conversioni via coda (modulo Job), con stato leggibile sul media. Se manca
l'anteprima si deve poter sapere **perche'**.

### 4. Il tipo di file va verificato dal contenuto, non dall'estensione

Un modulo che accetta caricamenti da utenti e' una superficie d'attacco. L'estensione
la sceglie chi carica.

**Azione:** validazione MIME reale, dimensione massima, e nessuna esecuzione dal
percorso di caricamento. Va scritto in `docs/security.md`: e' il tipo di requisito che
si da' per scontato finche' non viene disatteso.

### 5. 49 Action vogliono un catalogo

Come per Xot: senza un elenco con una riga di scopo, la 50esima Action sara' un
duplicato della 12esima.

## Confini — cosa **non** appartiene a Media

- Il **significato** del file: dominio. Media sa che e' un PDF di 2 MB, non che e' una
  certificazione.
- I **permessi** su chi lo vede: User + Policy del dominio.
- L'**esecuzione asincrona**: Job.

## Stato del codice rispetto allo scopo (verificato 2026-11-16)

I numeri sopra («49 Action», «124 file PHP», «zero Widget») sono datati: oggi 51 Action, 127 file PHP e un `ConvertWidget`.

| Promessa | Stato | Evidenza |
|---|---|---|
| Gli allegati-prova non si cancellano | **violata** | `DeleteAction` fisico, nessun `SoftDeletes` ([P1-4](./audits/media-audit.md#p1-4--cancellazione-fisica-degli-allegati-contraddice-lo-scopo-prova)) |
| I temporanei si ripuliscono con una regola | **non mantenuta** | `TemporaryUpload.php:241-244`, `model:prune` → `LogicException` ([P1-2](./audits/media-audit.md#p1-2--temporaryupload-non-viene-mai-ripulito-prunable-commentato)) |
| Conversioni accodate, fallimento visibile | **da verificare** | `MediaConvert` esiste; accodamento via Job non verificato |
| Tipo di file dal contenuto | **non verificato** | solo `Rules/FileExtensionRule` (estensione) |
| Azioni sul bucket solo a chi è autorizzato | **violata** | pagine `AwsTest`/`S3Test` senza guard ([P1-1](./audits/media-audit.md#p1-1--le-pagine-di-diagnostica-awss3-operano-sul-bucket-senza-autorizzazione-esplicita)) |

Riferimenti: [Audit](./audit.md) · [Architettura](./architecture.md) · [Decision log](./decision-log.md) · [Epics](./epics.md)

## Collegamenti

- `docs/wiki/memories/public-path-is-public-html.md` — il vincolo dei percorsi
- `laravel/Modules/Job/docs/purpose.md` — conversioni accodate
