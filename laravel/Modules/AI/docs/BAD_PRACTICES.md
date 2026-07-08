# Bad Practices – AI

## ❌ Usare `file_get_contents` per chiamare API
Usa `Http::` o Guzzle per timeouts/retries.

## ❌ Prompt hard‑coded in view
Sposta i messaggi in `lang/` o in file di configurazione.

## ❌ Non gestire errori API
Implementa fallback e logging di eccezioni.
