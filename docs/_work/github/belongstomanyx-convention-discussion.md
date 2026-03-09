Sto consolidando una convenzione che nel progetto doveva gia' essere ovvia ma non lo era a livello documentale:

- per le relazioni many-to-many applicative usiamo `belongsToManyX()`

non:

- `belongsToMany()`

La parte grave non era solo l'errore occasionale nel codice, ma la presenza di documentazione in conflitto che poteva rigenerare lo stesso errore in futuro.

Ho quindi normalizzato quattro livelli:

1. regola esplicita;
2. memoria operativa;
3. skill riutilizzabile;
4. memoria globale aggiornata.

Decisione architetturale:

- `belongsToManyX()` resta il default del progetto;
- `belongsToMany()` non va usato per inerzia framework;
- se esiste un'eccezione, va motivata e documentata.

Questo evita di perdere ogni volta il contesto architetturale specifico di LaravelPizza.
