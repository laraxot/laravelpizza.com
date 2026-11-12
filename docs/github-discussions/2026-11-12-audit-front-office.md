Categoria: General · Titolo: **Audit del front office (ospite e loggato): cosa abbiamo trovato e come lo controlliamo d'ora in poi**

Abbiamo controllato tutte le pagine pubbliche, da ospite e da utente loggato, su desktop e telefono (29 + 12 pagine, axe WCAG 2.1 AA, richieste a siti terzi, traduzioni). Dettagli e correzioni: issue #580 e `laravel/Themes/Meetup/docs/front-office-audit.md`.

I problemi più seri:
- "Password dimenticata" rispondeva con errore 500 (il broker puntava a una connessione database inesistente).
- L'email dell'organizzatore era pubblica nella pagina dell'evento; nel profilo pubblico email e indirizzo erano visibili a tutti.
- Gravatar caricava immagini da un sito terzo, contro quanto promette la cookie policy.
- Il logout dal menu mobile non disconnetteva.

Da ora il controllo si ripete con `cd laravel/Themes/Meetup && npm run audit:fo` (anche contro staging/produzione con `BASE_URL`).

**Domande aperte per la community / il team**
1. Vogliamo eseguire `audit:fo` in CI su ogni push a `dev` (serve un database con dati demo nel job)?
2. Quali altre pagine o flussi vorreste nel controllo automatico?
