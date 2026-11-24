---
title: "ADR — Un blocco con vista mancante mostra vista e tipo, mai il contenuto"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: UI
tags: [adr, blocks, privacy, rendering, front-office]
---

# ADR: vista mancante = avviso senza dati del blocco

## Contesto

`app/View/Components/Render/Block.php::render()` disegna blocchi salvati nei contenuti delle pagine. Se la vista in
`data.view` non esiste (tema cambiato, blocco rinominato, modulo rimosso) qualcosa va mostrato al posto del blocco, e
la tentazione per il debug è stampare il blocco intero. Ma il componente gira nel front office, davanti a chi visita
il sito: `data` può contenere testi in bozza, indirizzi email, configurazioni. Cosa mostra un blocco rotto?

## Decisione

- Senza `type` → vista `ui::empty`.
- Con vista inesistente → vista `ui::alert` con soli `title = 'deprecated'` e
  `message = 'view not exists [<vista>] (block type: <tipo>)'` (commento nel codice: "il contenuto del blocco non va
  mostrato a chi visita il sito").
- Nessuna eccezione: una pagina con un blocco rotto resta visibile.

## Alternative scartate

- **Dump del blocco (`dd`, JSON di `data`) nell'avviso**: espone dati non pubblicati o personali.
- **Eccezione / pagina 500**: un solo blocco rotto renderebbe irraggiungibile l'intera pagina.
- **Niente del tutto (vista vuota)**: il problema diventerebbe invisibile anche a chi gestisce il contenuto.

## Conseguenze

- Buono: chi gestisce il sito vede quale vista manca e di che tipo è il blocco, senza fughe di dati.
- Cattivo: l'avviso è visibile anche ai visitatori (nessuna distinzione per ruolo).

## Verifica

`cd laravel && vendor/bin/pest Modules/UI/tests/Unit/View/RenderBlockMissingViewTest.php`: fallisce se la vista non è
`ui::alert`, se i dati passati alla vista sono altri oltre `title` e `message`, o se compaiono valori di `data`.
