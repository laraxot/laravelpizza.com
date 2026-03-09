[Meetup Theme] Header auth CTA: localizzazione corretta e gerarchia UX login/register

Problema:

- su locale non italiana il nav puo' ancora renderizzare `Accedi` / `Registrati` perche' il Blade usa stringhe hardcoded;
- i CTA auth dell'header hanno gerarchia visiva migliorabile, soprattutto come distinzione tra azione secondaria (`login`) e primaria (`register`).

Obiettivo:

- usare solo chiavi `pub_theme::navigation.auth.*` nel Blade header;
- allineare i testi per locale (`Log in`, `Sign up`, ecc.);
- migliorare desktop/mobile auth CTA con microcopy e contrasto piu' chiari;
- coprire il comportamento con Pest test su pagine localizzate reali.
