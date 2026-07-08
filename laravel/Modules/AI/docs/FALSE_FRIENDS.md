# False Friends – AI

| Falso Amico | Perché fuorviante | Soluzione |
|-------------|-------------------|-----------|
| `Http::retry(3,100)` senza `throw: false` | L'eccezione finale non è gestita | Gestisci `ConnectException` |
| Prompt "system" come "user" | Confonde il modello | Separa per ruolo |
| Ignorare `max_tokens` | Risposte a metà tronche o lente | Valida la lunghezza attesa |
