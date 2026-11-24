---
title: "Lang — dati della vista language switcher"
type: contract
status: active
updated: 2026-11-23
---

# Contratto: dati della vista language switcher

## Input

La configurazione `laravellocalization.supportedLocales` e la richiesta HTTP corrente.

## Output

`LanguageSwitcherWidget::getAvailableLocales()` restituisce una collezione di record con `code`, `name`, `native_name`, `flag` e `url`.

## Invarianti

- `url` è già localizzato e può essere usato direttamente da una vista Blade;
- la vista non usa `$this`, `wire:click` o metodi Livewire;
- ogni URL è prodotto dalla stessa sorgente `LaravelLocalization` usata dal widget.

## Effetti collaterali

Nessuno: il cambio lingua è un normale link GET verso la pagina equivalente.

## Errori

Se il pacchetto non produce un URL per una lingua, il widget applica il proprio fallback `/<locale>`.

## Non fa

Non salva preferenze nel browser, non cambia la sessione tramite JavaScript e non inventa lingue.
