---
id: user-guest-project-names-removal
title: "Rimuovere nomi di progetti ospiti dal codice e dalle lingue di User"
type: story
status: open
priority: P2
owner: module:User
module: User
tags: [configurazione, multi-progetto, lang, namespace, pulizia]
related: []
---

# Rimuovere nomi di progetti ospiti dal codice di User

Fase BMAD: Dev (decisione di prodotto e di configurazione richiesta).

## Stato misurato
- Il test di architettura su nomi di progetti ospiti segnala 2 test e 44 file.
- Esempi: connessioni DB `fixcity`, namespace `Modules\Fixcity` (modulo assente), stringhe di brand in `User/lang`, sqlite cablato in 4 `TestCase`.

## Decisione da prendere
Per ogni occorrenza: (a) generalizzare con configurazione (`config`), (b) spostare nel progetto ospite, (c) eliminare se morta. Serve conferma di prodotto per i brand nelle lingue.

## Azioni
1. Elencare le occorrenze per file con la decisione.
2. Spostare connessioni e namespace in configurazione; rimuovere `Modules\Fixcity` se il modulo non esiste.
3. Sostituire sqlite cablato con la configurazione di test.

## Verifica
- Test architettura su nomi ospiti verde.
- Test User verdi, PHPStan `analyse Modules/User` pulito.
