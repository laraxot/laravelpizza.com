# Audit del front office

Controllo completo delle pagine pubbliche, da ospite e da utente loggato, su desktop e su telefono.
Da eseguire prima di ogni rilascio che tocca il tema, insieme a `npm run a11y` e ai test.

```bash
cd laravel/Themes/Meetup
npm run audit:fo                      # sito locale con i dati demo
BASE_URL=https://staging.example npm run audit:fo
# id dei profili demo da aprire (facoltativi)
USER_ID=<uuid partecipante> ORGANIZER_ID=<uuid organizzatrice> npm run audit:fo
# se il nome host non risolve (container, CI): MAP_HOST=127.0.0.1
```

Lo script (`scripts/front-office-audit.cjs`) apre ogni pagina con Playwright e segnala:

- stato HTTP (le tre pagine inesistenti dell'elenco devono dare 404);
- errori JavaScript e in console, risorse con errore;
- **richieste a siti terzi** (la cookie policy promette che non ce ne sono: niente Google Fonts, Gravatar, CDN);
- chiavi di traduzione non tradotte (`modulo::chiave`, `fields.x.label`);
- immagini rotte;
- numero di `<h1>` diverso da uno;
- `<title>` e meta description mancanti;
- scroll orizzontale su telefono;
- violazioni axe WCAG 2.1 A/AA (desktop).

Poi fa l'accesso con il partecipante demo, ripete le pagine da loggato, apre il menu mobile e prova il
logout da lì. Gli screenshot finiscono in `audit-shots/` (ignorata da git) insieme a `report.json`.
Esce con codice 1 se una pagina ha problemi.

## Audit del 12/11/2026: cosa è stato trovato e corretto

| Problema | Correzione |
|---|---|
| Tutte le pagine con lo stesso `<title>` e la descrizione "Gestione meta tag e SEO del sito web" | titolo e descrizione per pagina: `Modules/Cms/docs/page-title-and-description.md` |
| Email dell'organizzatore visibile a tutti nel dettaglio evento (due volte) | tolta |
| Profilo pubblico: email e indirizzo visibili a chiunque, email anche nel JSON-LD; id inesistente = pagina "utente anonimo" | email e indirizzo solo al titolare, niente email nel JSON-LD, id inesistente = 404 |
| Avatar da Gravatar (richiesta a un sito terzo con l'IP del visitatore) | `xra.gravatar = false`: iniziali in locale nel menu utente, nel menu mobile e nel profilo |
| "Password dimenticata" in errore: il broker usava la connessione `liveuser_general`, che non esiste | connessione `user` (tabella `password_resets` del modulo User); flusso completo coperto da test |
| Pagine password e verifica email in inglese fisso, senza `h1`, due loghi senza nome accessibile, SVG inline | rifatte con `<x-ui.auth-card>` e `<x-ui.auth-field>`, tradotte in 6 lingue |
| Link dell'email di reset sempre in italiano e senza email precompilata | `BuildPasswordResetUrlAction` usa la lingua della richiesta e aggiunge `?email=` |
| "Password dimenticata" diceva se un'email era registrata | stesso messaggio in ogni caso |
| Rimandare la verifica email faceva partire l'evento `Verified` | tolto; chi è già verificato viene mandato all'area personale |
| Pagina 404 di Laravel ("NOT FOUND", inglese, sfondo bianco) | pagine 403/404/419/429 nel layout del tema, tradotte; 500/503 autonome, senza database |
| Logout dal menu mobile: il form mandava un POST alla home, l'utente restava dentro | POST a `route('logout')` |
| "Toggle mobile menu" e "Skip to main content" non tradotti | `pub_theme::navigation.toggle_menu` / `skip_to_content` |
| Modalità dell'evento in inglese mostrata come `meetup::event_attendance_mode.…` | chiave `values.<caso>.label`, presente in tutte le lingue |
| Voce "Eventi vicini" nel menu utente che apriva l'elenco completo | "Tutti gli eventi" |
| Selettore lingua su telefono: solo un globo | nome della lingua visibile; ruoli ARIA `listbox/option` (sbagliati per dei link) sostituiti da `aria-current` |
| `/it/login` e `/it/register` davano 404 | alias verso `/it/auth/login` e `/it/auth/register` (`config/local/laravelpizza/seo.php`) |
| Email senza layout (il tema non aveva `resources/mail-layouts/base.html`) | layout del tema, solo HTML inline, nessuna immagine remota |

Test: `Modules/Meetup/tests/Feature/FrontOfficePrivacyAndSeoTest.php`.
