[Context]

Nel progetto LaravelPizza la convenzione corretta per le relazioni many-to-many applicative e':

- `belongsToManyX()`

non:

- `belongsToMany()`

Durante il lavoro recente e' emerso un problema di governance:

- esisteva documentazione in conflitto che consigliava `belongsToMany()`;
- questa documentazione era incompatibile con la convenzione reale usata dal progetto e con le memorie operative gia' presenti.

[Decision]

Rendere esplicito e canonico che:

- nei modelli applicativi del progetto si usa `belongsToManyX()`;
- `belongsToMany()` non va reintrodotto per abitudine Laravel standard;
- eventuali eccezioni devono essere documentate e motivate.

[Changes]

- corretta la regola `docs/rules/laravel-relationships-critical.md`;
- aggiunta memoria dedicata `docs/memory/belongstomanyx-relationship-memory.md`;
- aggiunta skill operativa `docs/skills/belongstomanyx-relationship-skill.md`;
- aggiornata la memoria globale `docs/memory/fundamental-rules-updated.md`.

[Outcome]

Da ora la convenzione `belongsToManyX()` non e' piu' implicita o contraddetta da file storici: diventa regola di progetto chiara, riutilizzabile e verificabile.
