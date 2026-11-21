---
title: "File parcheggiati — Job"
slug: parcheggio
module: Job
document_type: index
category: documentation
type: index
status: active
language: it-IT
created: 2026-11-18
updated: 2026-11-18
tags: [parcheggio, debito-tecnico]
description: "File con estensione finta spostati fuori da app/ in Job, con il motivo per ciascuna famiglia."
---

# File parcheggiati — Job

File spostati qui da `app/` il 2026-11-18. In `app/` sta solo codice che gira.

Un'estensione finta — `.boh`, `.up`, `.test`, `.disabled`, `.to_migra` — non
tiene un file fuori dal codice: lo rende invisibile a chi cerca e vivo per chi
lo trova. Il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove veniva.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Events/PresenceEvent.test` | 799 |


## Prima di riprenderne uno

Questi file **non sono stati esaminati riga per riga**: sono stati spostati,
non giudicati. Prima di copiarne uno nel codice vivo, confrontalo con quello
che c'e' adesso: in uno di questi, a ottobre, c'erano 135 righe di lavoro non
fuso che per poco non sono state cancellate. Quando il lavoro e' finito,
cancella il file parcheggiato.

Tracciato in
[module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61).
