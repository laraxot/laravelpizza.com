# Story 7.3: Riparazione del sync dei moduli e back office senza errori

Status: review

## Story

As an Organizzatore o amministratore,
I want che il sito e ogni pagina del pannello admin funzionino dopo l'aggiornamento dei moduli condivisi,
so that posso gestire eventi, utenti e impostazioni senza errori e la CI torna a proteggere i rilasci.

## Acceptance Criteria

1. Nessun file tracciato contiene marcatori di conflitto git; un test lo verifica (suite `Project`).
2. Un database vuoto si migra senza errori (`php artisan migrate` come in CI).
3. Ogni pagina GET dei pannelli Filament si apre come super-admin senza 4xx/5xx, errori JavaScript o Livewire e senza
   chiavi di traduzione grezze (`npm run audit:bo`).
4. Il pannello dell'organizzatore (`/meetup/admin`) ha titoli e pulsanti tradotti ("Nuovo evento", "Modifica sede", …),
   statistiche con testi tradotti, nessun widget segnaposto; l'importazione di eventi demo è visibile solo in locale.
5. Dopo il login l'utente arriva su `/{lingua}/events/my` (non su una pagina 404).
6. L'audit del front office (`npm run audit:fo`) non trova problemi; un URL senza contenuto risponde 404.
7. CI: build del tema, Pint, PHPStan e test bloccanti verdi.

## Tasks / Subtasks

- [x] Risolti 476 file con marcatori; test `NoMergeConflictMarkersTest` (AC 1)
- [x] `composer.lock` allineato (Filament 5.11.4, mailtrap, mail-mime-parser) (AC 7)
- [x] Migrazione unica di `users` del modulo User (upstream d8ef195): un db vuoto falliva (AC 2)
- [x] `XotBasePage`: `form()` che usa `schema()` e vista generica di ripiego (AC 3)
- [x] Corretti i 500 di Cms Headernav/Footer, Xot Metatag/Env, Geo OSMMap, Media S3/AWS, User Socialite, profili,
      tenant-users, upload temporanei, job, OAuth device code e client (AC 3)
- [x] Corretti errori JS/Livewire: Geo lat-lng, Media S3 test, User alignment e Socialite, dashboard UI (AC 3)
- [x] Meetup admin: titoli, pulsanti, widget statistiche su `XotBaseStatsOverviewWidget`, dashboard (AC 4)
- [x] `auth.post_login_path = /events/my` e test del redirect esatto (AC 5)
- [x] Nomi Volt del tema con prefisso `meetup.`; test `UniqueVoltFragmentNamesTest`; soft 404 → 404 (AC 6)
- [x] `.gitignore` del tema: gli script `scripts/*.mjs|cjs` in git (la build CI non trovava il postbuild) (AC 7)
- [x] Workflow: tolto `code-improvement.yml` (push automatico di codice generato da LLM, mai funzionante); corretto
      `semantic-versioning.yml` (tar dentro la cartella archiviata) (AC 7)
- [x] Script `npm run audit:bo`; runbook §9 e §11; docs Xot e tema

## Dev Notes

- Lezione e regole: `laravel/Modules/Xot/docs/lessons/module-sync-merge-conflicts.md`.
- XotBasePage: `laravel/Modules/Xot/docs/filament/xotbasepage-form-and-generic-view.md`.
- In locale `lang.save_missing_translations` è attivo: aprire le pagine admin scrive chiavi nei file lang. Dopo un
  audit si ripristinano con `git checkout -- ':(glob)laravel/Modules/*/lang/**'`.
- Da sistemare nei repository dei moduli (non qui): marcatori nei docs di Notify/Geo/Gdpr; logica `restaurant::admin`
  in `BaseUser::canAccessPanel` del modulo User (il modulo deve restare agnostico).
