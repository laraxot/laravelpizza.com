---
title: "helper text empty when redundant"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "helper text empty when redundant"
issues: []
discussions: []
name: helper-text-empty-when-redundant
description: "helper_text va svuotato quando coincide con la chiave dell'array (nome campo non tradotto); label/placeholder/description restano invariati"
metadata:
  type: lesson-learned
  created: 2026-09-15
  github_issues: []
---

# `helper_text` vuoto quando coincide con la chiave del campo

## L'errore che si è ripetuto (su scala)

In 410 file `lang/it/*.php` di 18 moduli diversi, questo pattern:

```php
'dal' => [
    'label' => 'dal',
    'placeholder' => 'dal',
    'helper_text' => 'dal',   // ← identico alla chiave 'dal'
    'description' => 'dal',
],
```

2805 occorrenze totali corrette.

## Perché è sbagliato

Root cause: un tool di generazione automatica delle traduzioni duplicava il nome del campo
su tutti e 4 gli attributi come placeholder iniziale, mai sostituito con una traduzione
reale per `helper_text`. Un `helper_text` che ripete solo il nome del campo non aggiunge
nessuna informazione all'utente — è rumore, non aiuto.

**Solo `helper_text` va svuotato**, non gli altri tre attributi: `label`, `placeholder` e
`description` restano visibili e utili come fallback UI anche se non ancora tradotti
(mostrano almeno il nome del campo), mentre `helper_text` è testo di aiuto supplementare —
se non aggiunge nulla oltre al nome, va tolto.

## Come si fa correttamente

```php
'dal' => [
    'label' => 'dal',
    'placeholder' => 'dal',
    'helper_text' => '',      // ← svuotato, nessuna informazione persa
    'description' => 'dal',
],
```

Il confronto è sempre fra `helper_text` e la **chiave dell'array** (`'dal'`), non fra
`helper_text` e gli altri attributi dello stesso blocco.

## Come riconoscerlo in futuro

Per un singolo file:

```bash
php -r '
$a = include "lang/it/esempio.php";
foreach ($a as $key => $v) {
    if (isset($v["helper_text"]) && $v["helper_text"] === (string) $key) {
        echo "$key: helper_text ridondante\n";
    }
}
'
```

Da applicare quando si genera una nuova traduzione o se ne importa una da un tool
automatico: verificare sempre che `helper_text` non sia un mero eco del nome campo.

## Riferimenti

- Memory: `helper-text-empty-when-equals-key.md`
- 18 commit, uno per modulo (Activity, Incentivi, IndennitaCondizioniLavoro,
  IndennitaResponsabilita, Job, Lang, Media, Notify, Pdnd, Performance, Progressioni, Ptv,
  Rating, Sigma, Tenant, UI, User, Xot)
