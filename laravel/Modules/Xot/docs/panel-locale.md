---
title: Lingua dei pannelli Filament
updated: 2026-11-19
---

# Lingua dei pannelli Filament

I pannelli (`/{modulo}/admin`) non hanno la lingua nell'URL. `SetPanelLocaleFromUserMiddleware` applica la **lingua
preferita dell'utente** (`users.lang`, scelta dal profilo) dopo l'autenticazione.

- Registrato come auth middleware **persistente** in `XotBasePanelProvider` e `XotBaseMainPanelProvider`: vale anche
  per le richieste Livewire (azioni di tabella, modali).
- Applica la lingua solo se è supportata: chiavi di `laravellocalization.supportedLocales`, oppure `app.locale` e
  `app.fallback_locale` se il pacchetto non c'è. Altrimenti resta `app.locale`.
- Imposta anche `Carbon::setLocale()` per date e tempi relativi.
- La pagina di login resta in `app.locale`: prima dell'accesso l'utente non è noto.

Perché un pannello sia davvero in una lingua servono le traduzioni dei moduli in `lang/{lingua}`: le etichette senza
traduzione compaiono come chiavi grezze (per esempio `social provider.navigation`) o in italiano.

Origine: laraxot/laravelpizza.com, issue #583. Test: `Modules/Meetup/tests/Feature/Admin/OrganizerPanelTest.php`.
