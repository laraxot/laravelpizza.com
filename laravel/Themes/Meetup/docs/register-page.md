---
title: "Pagina di registrazione"
type: guide
status: active
theme: Meetup
qmd: "register page registrazione signup clickbait gdpr consensi widget layout animazioni wcag seo traduzioni gdpr::register particles"
---

# Pagina di registrazione

La registrazione e' la pagina a piu' alta conversione del sito: deve essere accattivante ma accessibile, tradotta e conforme al GDPR. Questa pagina riassume com'e' fatta davvero, chi possiede cosa e cosa e' stato deciso o scartato. Le altre pagine di auth stanno in [authentication-ui-ux](authentication-ui-ux.md).

## Chi possiede cosa

| Livello | File | Responsabilita' |
|---|---|---|
| Tema | `Themes/Meetup/resources/views/pages/auth/register.blade.php` (Folio, `name('register')`, `middleware(['guest'])`) | cornice: sfondo animato, logo, `h1`, scheda del form, benefici |
| Modulo Gdpr | `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` (Livewire, estende `XotBaseWidget`) | campi, validazione, rate limit, consensi, creazione utente |
| Modulo Gdpr | `Modules/Gdpr/lang/<locale>/register.php` (`gdpr::register.*`) | tutti i testi della pagina e del form |
| Modulo User | `CreateUserAction`, `LogRegistrationAction`, `PasswordData` | creazione utente, log, regole password |
| Modulo Gdpr e tema | `Modules/Gdpr/resources/views/filament/widgets/auth/register.blade.php` e la copia in `Themes/Meetup/resources/views/filament/widgets/auth/register.blade.php` | markup custom del form (non usa `getFormSchema()`): campi e consensi con link cliccabili a privacy e termini; entrambe contengono ancora `<svg>` inline (vedi debiti) |

La pagina del tema non contiene logica: e' una scelta dell'[ADR](adr/auth-forms-are-module-widgets.md) ed e' verificata da `PagesAndAuthFormsContractTest`. Proprieta' dei testi del widget: `Modules/Gdpr/docs/register-widget-copy-ownership.md`.

## Il form (RegisterWidget)

- Campi: `first_name`, `last_name` (obbligatori, 2-255), `email` (unica in `user.users`), `password` (`Password::defaults()`, cioe' le regole di `PasswordData`), `password_confirmation` (`same:password`), `privacy_accepted` e `terms_accepted` (devono essere `accepted`, messaggi tradotti `gdpr::register.consents.*_required`), `marketing_consent` (facoltativo), `show_password` (toggle visibilita').
- I messaggi di errore usano le stesse etichette visibili sopra i campi, nella lingua della pagina (`validationAttributes()`).
- Anti-abuso: massimo 10 invii per IP in 600 secondi (`MAX_ATTEMPTS`, `DECAY_SECONDS`), ogni invio conta; superato il limite l'errore e' su `email` con `gdpr::register.throttle`.
- Invio: validazione, `ValidateGdprConsentAction`, `ValidateUserDataAction`, poi in una transazione sulla connessione `user`: `CreateUserAction` + `SaveGdprConsentsAction` + `LogRegistrationAction` (consensi tracciati con l'utente); infine `HandleSuccessfulRegistrationAction`. Il nome mostrato (`name`) e' `first_name + last_name`; nel log di debug l'email e' solo in hash.
- Il widget e' visibile solo agli ospiti (`canView()` = `! Auth::check()`).
- Dopo la registrazione parte l'email di verifica ([authentication-ui-ux](authentication-ui-ux.md): `verification.notice`).

## Cornice del tema

- Sfondo `bg-gradient-to-br from-slate-900 via-slate-800 to-red-900` (varianti `dark:`), `main` con `role="main"` e `aria-labelledby="main-heading"`, `h2` `sr-only` per scheda e benefici, particelle interattive (`@include('pub_theme::components.ui.particles')`, vedi [design-system](design-system.md)).
- Logo da file SVG con `<x-filament::icon icon="meetup-logo">` e link localizzato a `LaravelLocalization::localizeUrl('/')`.
- Tre "benefici" (community, tutorial, networking) con testi `gdpr::register.benefits.*`; testo `gdpr::register.form.terms_notice` sotto il form.
- Animazioni decorative (blob, emoji pizza fluttuanti, gradienti) definite in blocchi `<style>` della Blade con `@keyframes`; **tutte annullate** da `@media (prefers-reduced-motion: reduce)`. Elementi decorativi con `aria-hidden="true"`.
- Titolo e description della pagina: `gdpr::register.title` e `gdpr::register.subtitle` passati a `<x-layouts.app>`.

## Decisioni e lezioni

- **La pagina non e' una copia 1:1 di laravelpizza.com/register**: l'originale ha tre campi e nessun consenso; la nostra ha conferma password e consensi GDPR obbligatori per legge e per scelta di prodotto. Non "correggerla" verso l'originale togliendo i consensi. Lezione generale: prima di allineare una pagina all'originale, guardarla davvero (vedi [visual-parity](visual-parity.md)) e non aggiungere o togliere elementi a memoria.
- Tono "clickbait" (titolo, sottotitolo, benefici, CTA orientata all'azione) ma sempre veritiero: niente numeri inventati (utenti, urgenza finta). I testi vivono in chiavi di traduzione; vedi [social-share-and-marketing](social-share-and-marketing.md).
- Contrasto, focus visibile, bersagli 44x44 px, errori associati ai campi: criteri in [accessibility](accessibility.md); consensi e informative: [gdpr-compliance](gdpr-compliance.md).
- Idee valutate e **non implementate** (non assumerle presenti): registrazione con social login in primo piano (esiste `SocialLoginWidget` nel modulo User ma la pagina non lo usa), wizard multi-step con progress, indicatore di forza password dedicato, signup a zero campi, etichette flottanti. Sono candidate per [roadmap](roadmap.md), da fare dentro il widget (logica nel modulo), non nella Blade.

## Debiti noti sulla Blade

- Le icone dei tre benefici sono `<svg>` inline: la regola del progetto e' un file in `Modules/Meetup/resources/svg/` richiamato con `<x-filament::icon icon="meetup-...">` ([svg-icons-no-hardcoded-blade](svg-icons-no-hardcoded-blade.md)).
- I `@keyframes` stanno in `<style>` nella pagina; spostarli in `resources/css/app.css` evita duplicati (esiste un secondo blocco `@keyframes blob`).
- Le emoji pizza decorative sono testo nella Blade: accettabili perche' `aria-hidden`.

## Vedi anche

- [authentication-ui-ux](authentication-ui-ux.md) — login, password, verifica, logout
- [gdpr-compliance](gdpr-compliance.md), [accessibility](accessibility.md), [seo-structured-data](seo-structured-data.md)
- [localization-standard](localization-standard.md)
