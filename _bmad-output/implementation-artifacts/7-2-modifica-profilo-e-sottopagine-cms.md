# Story 7.2: Modifica del profilo dal sito e sotto-pagine CMS nelle cartelle

Status: review

## Story

As a Partecipante,
I want modificare nome, biografia, foto, lingua e password dal sito,
so that il mio profilo pubblico mi rappresenta senza dover chiedere a un amministratore.

## Acceptance Criteria

1. `/{lingua}/profile/edit` esiste come pagina CMS `pages/profile/edit.json` (slug `profile.edit`), con middleware `auth`.
2. Dati, foto e password si salvano separatamente, con validazione e conferma accessibile (`role="status"`).
3. La password cambia solo con quella attuale corretta; le altre sessioni vengono chiuse.
4. La foto: JPG/PNG/WebP fino a 2 MB, una sola per volta, rimovibile (tornano le iniziali).
5. Le sotto-pagine dei contenitori stanno nelle cartelle (`pages/events/my.json`, `past.json`, `view.json`,
   `pages/profile/view.json`); i vecchi URL `/events-my` e `/events-past` reindirizzano (301).
6. Nessun evento può prendere lo slug di una sotto-pagina di `events`.
7. I test girano con la stessa configurazione del tenant reale (`xra.main_module = Meetup`).

## Tasks / Subtasks

- [x] JSON `pages/profile/edit.json` (6 lingue) e spostamento delle sotto-pagine in `pages/events/` e `pages/profile/` (AC 1, 5)
- [x] `PageSlugMiddleware`: il percorso è il primo candidato; tolte le varianti con il trattino (AC 1, 5)
- [x] Rotta `pages/profile/[id].blade.php` con sotto-pagine `profile.*` e profilo pubblico via `<x-page>` (AC 1)
- [x] Livewire `ProfileEditForm` + Actions `Modules\Meetup\Actions\Profile\*` + DTO `OwnProfileData` (AC 2-4)
- [x] Migrazione `add_bio_locale_address_to_profiles_table` (la tabella profiles del modulo Meetup non le aveva)
- [x] `Event::uniqueSlug()` riserva gli slug delle sotto-pagine (AC 6)
- [x] `Modules/Meetup/tests/TestCase.php` con `main_module = Meetup` (AC 7)
- [x] Fix sicurezza: password di 32+ caratteri salvate in chiaro (`BaseUserMutators::setPasswordAttribute`)
- [x] Link "Modifica il profilo" nel menu utente, nel menu mobile, sul proprio profilo
- [x] Test `ProfileEditPageTest` (10), manuale d'uso §2.6 con screenshot e PDF

## Dev Notes

- Convenzione: `laravel/Modules/Cms/docs/cms-subpages-folders.md`.
- Analisi dell'errore che aveva appiattito le sotto-pagine: `laravel/Modules/Cms/docs/lessons/flattened-cms-subpages-error-analysis.md`.
- Pagina: `laravel/Themes/Meetup/docs/profile-edit-page.md`.
