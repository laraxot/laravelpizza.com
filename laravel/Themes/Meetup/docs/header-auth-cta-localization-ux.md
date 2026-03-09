# Header Auth CTA Localization UX

## Problema

Nel nav pubblico del tema non possono comparire CTA auth in italiano quando la pagina e' in una lingua diversa.

Inoltre i due bottoni devono avere una gerarchia visiva piu' chiara:

- `login` come azione secondaria;
- `register` come CTA primaria.

## Regola

I CTA auth dell'header devono usare solo chiavi di traduzione del tema:

- `pub_theme::navigation.auth.login`
- `pub_theme::navigation.auth.register`

Mai stringhe hardcoded come `Accedi` o `Registrati` dentro il Blade.

## UI/UX direction

Le linee guida pratiche adottate per il tema:

- secondary action discreta ma chiaramente cliccabile;
- primary action piu' prominente, con contrasto alto e shape coerente;
- copy breve e standard (`Log in`, `Sign up`, equivalenti locali);
- mobile CTA full-width e facili da toccare;
- stato hover/focus visibile e non solo cromatico.

## Motivazione

- la lingua del nav deve essere coerente con la pagina;
- CTA auth standard e riconoscibili riducono esitazione;
- il contrasto tra azione secondaria e primaria aiuta scansione e conversione.

## Verifica minima

- `/it` mostra `Accedi` e `Registrati`
- `/en` non mostra `Accedi` / `Registrati`
- `/en` mostra `Log in` e `Sign up`
- il test Pest deve bloccare regressioni future
