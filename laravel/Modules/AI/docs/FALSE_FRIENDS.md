---
title: "FALSE FRIENDS"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "FALSE FRIENDS"
issues: []
discussions: []
---

# False Friends – AI

| Falso Amico | Perché fuorviante | Soluzione |
|-------------|-------------------|-----------|
| `Http::retry(3,100)` senza `throw: false` | L'eccezione finale non è gestita | Gestisci `ConnectException` |
| Prompt "system" come "user" | Confonde il modello | Separa per ruolo |
| Ignorare `max_tokens` | Risposte a metà tronche o lente | Valida la lunghezza attesa |
