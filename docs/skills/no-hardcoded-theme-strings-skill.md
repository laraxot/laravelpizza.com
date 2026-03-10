# no-hardcoded-theme-strings-skill.md

## Obiettivo

Applicare e verificare la regola "nessuna stringa UI hardcoded nei temi".

## Workflow

1. Studiare la documentazione locale del tema e del modulo che rende il markup.
2. Cercare stringhe hardcoded nel Blade o nel componente coinvolto.
3. Spostare il testo in chiavi di traduzione del namespace corretto.
4. Verificare che tutte le lingue supportate abbiano la chiave minima necessaria.
5. Se esiste un componente condiviso che puo' evitare duplicazioni, riusarlo.
6. Se vengono toccati file PHP, eseguire `phpstan`, `phpmd`, `phpinsights` e Pest mirato.
7. Aggiornare GitHub Discussions quando la regola ha impatto architetturale o operativo.

## Checklist rapida

- nessun testo UI raw nel Blade;
- nessun fallback italiano in locale non italiana;
- namespace traduzione coerente (`pub_theme::` o `module::`);
- almeno un test di feature sul markup finale quando il testo e' pubblico.
