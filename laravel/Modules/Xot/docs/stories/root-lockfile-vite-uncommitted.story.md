---
title: Decidere il package-lock.json modificato per vite
status: open
owner: Xot
created: 2026-10-27
---

# Decidere il package-lock.json modificato per vite

## Fase BMAD

Dipendenze: lock non committato.

## Problema

laravel/package-lock.json risulta modificato (allineato a vite ^6.4.3), non committato. Lo script postinstall di esbuild non e approvato.

## Domande aperte

1. Il lock va committato?
2. esbuild puo eseguire lo script postinstall?

## Prossimi passi

git diff per verificare. Committare solo con conferma. Eseguire npm ci in ambiente pulito per prova.

## Stato

Aperta. Da chiudere con una verifica reale (test, lint o prova nel browser), non con una dichiarazione.
