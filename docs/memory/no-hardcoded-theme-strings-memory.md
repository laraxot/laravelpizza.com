# Memory: No Hardcoded Theme Strings

- nei temi nessuna stringa UI va hardcoded nei Blade;
- il namespace canonico del tema e' `pub_theme::...`;
- se il testo e' di dominio modulo si usa il namespace modulo, non una stringa raw nel tema;
- una pagina `/de`, `/en`, `/fr`, `/es`, `/ru` non puo' contenere fallback italiani nel markup finale;
- quando trovo stringhe hardcoded in un tema, prima aggiorno docs locali del tema, poi `docs/rules`, `docs/memory`, `docs/skills`, poi correggo il rendering e i test;
- i componenti condivisi devono centralizzare copy e stile per evitare divergenze tra tema e moduli.
