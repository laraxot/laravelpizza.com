# No Log::info Rule

Nel codice runtime progetto non si usa `Log::info(...)`.

Motivazioni pratiche:
- rumore elevato nei log;
- costo I/O evitabile;
- rischio leakage dati non essenziali in ambienti condivisi.

Politica:
- evitare logging informativo persistente;
- usare `Log::debug(...)` solo quando strettamente necessario e con payload minimo;
- privilegiare test + metriche applicative al posto di logging verboso.
