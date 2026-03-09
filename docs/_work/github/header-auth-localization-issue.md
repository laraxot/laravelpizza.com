[Context]

Nella header navigation del tema Meetup le CTA guest auth mostravano label italiane anche su locale non italiano.

Problema concreto:

- su `/de` comparivano ancora label italiane come `Accedi` / `Registrati`
- i link della navigation usavano anche path non coerenti con le route pubbliche auth (`/login`, `/register` invece di `/auth/login`, `/auth/register`)

[Why this is severe]

- rompe la localizzazione visibile del frontoffice;
- rende inattendibili i test se controllano solo status o `lang` HTML;
- peggiora UX e fiducia, soprattutto nell'header che e' il punto di navigazione principale.

[Changes]

- allineate le CTA auth della headernav alle traduzioni `pub_theme::navigation.auth.*`
- corretti i link localizzati verso `/auth/login` e `/auth/register`
- mantenuta una gerarchia UI chiara:
  - login secondaria
  - register primaria
- aggiunto test Pest su homepage localizzate `/it` e `/de`

[Verification]

- `/it` deve mostrare `Accedi` / `Registrati`
- `/de` non deve mostrare label italiane
- `/de` deve mostrare le label tedesche e i link localizzati corretti
