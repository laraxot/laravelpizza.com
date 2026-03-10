# No Hardcoded Theme Strings Rule

## Regola

Nel tema non devono esistere stringhe UI hardcoded nei Blade, nei componenti, nei layout o nei block pubblici.

Ogni testo visibile all'utente deve arrivare da chiavi di traduzione del namespace corretto, in particolare:

- `pub_theme::...` per le traduzioni del tema;
- `module::...` per testi canonici che appartengono a un modulo.

## Perche'

- evita mismatch tra lingua URL e lingua resa in pagina;
- impedisce fallback italiani dentro pagine tedesche, francesi, inglesi, spagnole o russe;
- rende testabile la localizzazione reale del markup;
- mantiene DRY il copy pubblico invece di duplicarlo nei Blade.

## Regole operative

- vietato scrivere label UI raw come `Accedi`, `Registrati`, `Dashboard`, `Settings`, `Profile`, `Log Out`, `Esci` dentro i Blade del tema;
- vietato usare copy hardcoded per CTA, nav, footer, banner, heading, empty states e messaggi;
- quando serve una nuova label, prima si crea la chiave di traduzione in tutte le lingue supportate e poi si usa nel Blade;
- se una view del modulo rende markup del tema, anche li' il testo deve passare da chiavi di traduzione, non da stringhe raw;
- il tema non deve diventare il posto dove si "ripara" una localizzazione mancante con fallback hardcoded.

## Verifica minima

- controllare il Blade toccato per assenza di stringhe UI hardcoded;
- verificare almeno una route localizzata non italiana;
- se la modifica coinvolge file PHP, eseguire `phpstan`, `phpmd`, `phpinsights` e Pest mirato;
- aggiornare i test di feature quando il testo finale della pagina e' parte del comportamento pubblico.
