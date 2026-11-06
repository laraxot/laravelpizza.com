---
title: Capire chi ha sovrascritto le icone SVG di Progressioni
status: open
owner: Xot
created: 2026-10-27
---

# Capire chi ha sovrascritto le icone SVG di Progressioni

## Fase BMAD

Attribuzione: file modificati da un'altra sessione.

## Problema

I sei SVG in Progressioni/resources/svg sono stati riscritti alle 13:09-13:10 con set Feather (stroke-width 2) e un polizia placeholder, dopo che li avevo creati con set heroicon. Non so quale sessione li abbia scritti. Ho rigenerato i file. Il dirigenti e stato poi cambiato in building-library per scelta dell'utente.

## Domande aperte

1. Quale processo o sessione ha scritto quei file?
2. Serve un controllo per evitare la sovrascrittura silenziosa?

## Prossimi passi

Controllare il log di sessione. Se non trovato, aggiungere un controllo di hash nella storia delle icone. Confermare la scelta building-library con l'utente.

## Stato

Aperta. Da chiudere con una verifica reale (test, lint o prova nel browser), non con una dichiarazione.
