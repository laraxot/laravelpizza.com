---
title: "Header, footer e logo"
type: reference
status: active
theme: Meetup
qmd: "header footer logo navigation nav auth cta login register svg icone meetup-logo menu mobile pizza slice branding"
---

# Header, footer e logo

## Perche' esiste

Header e footer sono la parte del sito che ogni pagina mostra: devono avere lo stesso logo, link sempre localizzati, testi tradotti e nessuna icona incollata come SVG nel Blade. Qui sta come sono fatti oggi, le regole che li governano e i difetti noti. Il selettore lingua ha una pagina propria: [language-switcher.md](language-switcher.md).

## Dove sono

| Pezzo | File |
|---|---|
| Header (nav sticky) | `resources/views/components/sections/header/v1.blade.php` |
| Footer | `resources/views/components/sections/footer/v1.blade.php` |
| Logo come componente | `resources/views/components/ui/logo.blade.php` |
| CTA di accesso condivise | `resources/views/components/ui/auth-buttons.blade.php` |
| Icone | `Modules/Meetup/resources/svg/*.svg` |

Header e footer sono resi da `<x-section slug="header"/>` e `<x-section slug="footer"/>` in `x-layouts.app` (meccanismo in [layouts.md](layouts.md)).

## Header

`<nav id="main-navigation" role="navigation">` con `sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md`, `aria-label` da `pub_theme::navigation.main`.

- **Logo + nome**: link alla home localizzata (`LaravelLocalization::localizeUrl('/')`), `aria-label` da `pub_theme::navigation.site_title`; icona `meetup-logo` (`h-12 w-12 text-red-500`) e il testo "Laravel Pizza Meetups" su una sola riga, come sul sito originale.
- **Desktop** (da `md`): Home, Eventi (icona calendario), Chat community (`href="#"`, segnaposto), selettore lingua.
- **Ospite** (`@guest`): Accedi come azione secondaria (bordo e fondo trasparenti `border-white/15 bg-white/5`), Registrati come CTA primaria (gradiente `from-red-500 via-red-600 to-orange-500`). **Autenticato**: widget Livewire `Modules\User\Filament\Widgets\UserDropdown`.
- **Mobile**: pulsante `#mobile-menu-button` (icona `meetup-icon-menu`) che apre `#mobile-menu` con link, selettore lingua (`<x-ui.language-switcher mobile />`) e CTA a tutta larghezza.

### Regola: CTA di accesso localizzate e con gerarchia

- Le etichette vengono sempre dalle chiavi foglia `pub_theme::navigation.auth.login.label` e `pub_theme::navigation.auth.register.label` (file `lang/<locale>/navigation.php`). Mai `Accedi`, `Registrati` o altro testo italiano scritto nel Blade, e nessun fallback italiano nelle altre lingue.
- Gli URL passano da `LaravelLocalization::localizeUrl('/auth/login')` e `('/auth/register')`.
- Gerarchia: login secondario, registrazione primaria; stesso significato su desktop e mobile; bersagli di tocco generosi; hover e `focus-visible` con anello visibile (non solo cambio di colore), testo breve e standard.
- Perche': la lingua del nav deve coincidere con quella della pagina e due azioni di peso diverso riducono l'esitazione.
- Test: `Modules/Meetup/tests/Feature/HeaderLocalizationTest.php` (etichette nella lingua dell'URL per `it en de fr es ru`, nessuna label italiana fuori da `/it`, classi della gerarchia) e `HeaderNavigationTest.php` (voci per ospite e menu utente da autenticato).

## Footer

`<footer role="contentinfo">` su `bg-slate-950 border-t border-slate-800`, griglia a 4 colonne da `md`:

1. Logo (`meetup-logo`, `h-12 w-12`) con il nome e la descrizione `pub_theme::navigation.footer.community.description`.
2. Community: Eventi, Chat (`/chat`), Codice di condotta (`#`), Registrati per gli ospiti o Profilo per gli autenticati.
3. Risorse: Laravel, Filament e Livewire Docs in nuova scheda (`target="_blank" rel="noopener noreferrer"` con testo `sr-only`), Blog (`#`).
4. Seguici: icone `meetup-facebook`, `meetup-twitter`, `meetup-github` (`href="#"` per ora).

In coda la riga `&copy; <anno> Laravel Pizza Meetups` con `pub_theme::navigation.footer.all_rights_reserved.label`. Link di navigazione con `nav` e `aria-label` tradotti. Il sito di riferimento aveva anche "Made with ... for the Laravel community": non e' presente nel footer attuale.

## Logo

- **Sorgente unica**: `Modules/Meetup/resources/svg/logo.svg` (icona `meetup-logo`; il file `meetup-logo.svg` e' un duplicato identico che darebbe `meetup-meetup-logo`, da non usare): spicchio di pizza a tratto (viewBox 24, `stroke="currentColor"`, spessore 2, tracciato `m2 16 20 6-6-20A20 20 0 0 0 2 16` con tre puntini), lo stesso di laravelpizza.com. Il colore lo decide la classe del chiamante (`text-red-500`).
- **Uso**: `<x-filament::icon icon="meetup-logo" class="h-12 w-12 text-red-500" />` in header, footer, login, registrazione e nel componente `x-ui.logo`. In `config/local/laravelpizza/metatag.php` i campi `logo_*` puntano a `meetup::svg/logo.svg`.
- **Non sovrascrivere** `logo.svg` con altre interpretazioni (versioni "illustrate" con crosta, pepperoni e sfumature sono state provate e scartate: non fedeli al marchio) senza richiesta esplicita del committente.
- **Lezione**: un asset di marca si estrae dall'originale e si confronta a occhio con uno screenshot prima di darlo per finito; non si ridisegna. Se il dominio di produzione non serve l'app (e' capitato: pagina segnaposto del provider), il confronto va fatto su staging o sugli screenshot salvati in `visual-analysis/footer/` ([locale](visual-analysis/footer/footer-locale-it.png), [produzione](visual-analysis/footer/footer-laravelpizza-com.png)), non fidandosi del dominio.

## Icone: file `.svg`, mai inline

Regola di progetto: nelle Blade niente `<svg>` incollato. Si crea il file in `Modules/Meetup/resources/svg/` e si richiama con `<x-filament::icon icon="meetup-{nome}" class="..." />` (il set `meetup` e' registrato da `XotBaseServiceProvider` leggendo `resources/svg`). Vantaggi: un'icona definita una volta, modificabile da un designer senza toccare le viste, coerenza tra header, footer e blocchi. Dettaglio e catalogo in [svg-icons-no-hardcoded-blade.md](svg-icons-no-hardcoded-blade.md).

Nomi disponibili oggi: `meetup-logo`, `meetup-icon-calendar`, `-chat`, `-check`, `-chevron-down`, `-arrow-down`, `-close`, `-community`, `-language`, `-menu`, `-send`, `-sponsors`, `meetup-facebook`, `-twitter`, `-github`, `meetup-pizza`. Per un'icona generica si usano anche i set Heroicons (`heroicon-o-*`, `<x-heroicon-o-*>`).

Controllo: `grep -rln "<svg" laravel/Themes/Meetup/resources/views`. Header e footer `v1` sono puliti; restano SVG inline in altre viste (registrazione, `ui/*`, alcuni blocchi): vedi "Da verificare".

## Errori tipici

| Sintomo | Causa | Rimedio |
|---|---|---|
| Su `/en` o `/de` compaiono `Accedi`/`Registrati` | Label scritta nel Blade o chiave non tradotta | Usa le chiavi `.label` e aggiungile in tutte le lingue; `ThemeIntegrityTest` fallisce se una chiave letterale manca in `it` o `en` |
| Il link porta a una pagina senza prefisso lingua | `href` costruito a mano | `LaravelLocalization::localizeUrl('/percorso')` |
| Logo "diverso" tra header e footer | Icona o componente duplicati | Usa sempre `meetup-logo` |
| Icona assente | Nome `meetup-*` inesistente o file non in `Modules/Meetup/resources/svg` | Controlla il nome con `ls` della cartella |

## Da verificare

- Menu mobile: lo stato Alpine `mobileMenuOpen` sul pulsante non e' collegato a nulla; il menu lo apre `resources/js/app.js` (toggle di `hidden`), e li' `aria-expanded` e' calcolato prima del toggle, quindi risulta invertito.
- Il form di logout del menu mobile ha `action="/{locale}"` (home): da riallineare alla rotta POST `logout` di `Modules/User`. Il link "Dashboard" dello stesso menu punta a una pagina pubblica che non esiste piu' (il test dell'header dice che l'area personale e' "I miei eventi").
- Markup delle CTA duplicato in `header/v1` (desktop e mobile) e in `blocks/navigation/v1`, mentre `ui/auth-buttons` esiste e dovrebbe essere l'unico punto.
- `header.json`/`footer.json` (sezioni CMS) dichiarano blocchi e un logo `/themes/Meetup/images/pizza-slice-logo.svg` che non esiste in `public/images`; le viste `v1` non li usano.
- Il nome "Laravel Pizza Meetups" e' scritto direttamente in header e footer (marchio, non UI), mentre `site_title` esiste gia' in `navigation.php`.
- Voci `#` (chat, codice di condotta, blog, social) ancora segnaposto.
- File SVG `logo-header.svg`, `meetup-logo.svg` (duplicato di `logo.svg`) e `pizza.svg` in `Modules/Meetup/resources/svg`: nessuna vista del tema li usa.

## Vedi anche

- [layouts.md](layouts.md)
- [language-switcher.md](language-switcher.md)
- [localization-standard.md](localization-standard.md)
- [svg-icons-no-hardcoded-blade.md](svg-icons-no-hardcoded-blade.md)
- [visual-parity.md](visual-parity.md)
