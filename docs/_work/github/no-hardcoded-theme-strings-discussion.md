Nuova regola di governance fissata:

- nei temi non devono esistere stringhe UI hardcoded nei Blade, nei layout o nei componenti pubblici;
- ogni testo visibile all'utente deve usare chiavi di traduzione del namespace corretto:
  - `pub_theme::...` per il tema
  - `module::...` per il modulo proprietario del testo

Perche' la sto formalizzando:

- un URL localizzato non garantisce da solo che il markup finale sia nella lingua corretta;
- stringhe hardcoded nel tema introducono fallback italiani o copy divergente tra pagine e componenti;
- il problema e' architetturale, non solo di singola view: se non c'e' una regola canonica, gli agenti continuano a reinserire testo raw nei Blade.

Aggiornamenti locali fatti:

- `laravel/Themes/Meetup/docs/no-hardcoded-theme-strings-rule.md`
- `docs/rules/no-hardcoded-theme-strings-rule.md`
- `docs/memory/no-hardcoded-theme-strings-memory.md`
- `docs/skills/no-hardcoded-theme-strings-skill.md`

Da qui in avanti il tema deve considerare stringhe UI hardcoded come regressione, al pari di URL non localizzati o SVG inline vietati.
