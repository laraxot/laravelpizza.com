---
title: "Accessibilita' (WCAG) del tema"
type: guide
status: active
theme: Meetup
qmd: "accessibilita wcag 2.1 2.2 aa aaa contrasto focus tastiera skip link aria landmark reduced motion screen reader axe a11y touch target form errori"
---

# Accessibilita' (WCAG) del tema

L'accessibilita' non e' una fase finale: i criteri sotto valgono per ogni blocco, layout e pagina del tema (la registrazione e le pagine auth sono il caso piu' esigente: [register-page](register-page.md), [authentication-ui-ux](authentication-ui-ux.md)).

## Obiettivo e verifica

- Livello obiettivo: **WCAG 2.2 AA** (richiesto anche dall'European Accessibility Act). I report storici parlano di AAA e di "2.1 AA": la linea operativa e' AA; si prende l'AAA (contrasto 7:1, nessun limite di tempo) dove costa poco, mai come requisito bloccante.
- Verifica automatica: `npm run a11y` (`scripts/a11y-audit.mjs`, axe-core con i tag `wcag2a, wcag2aa, wcag21a, wcag21aa`) sulle pagine pubbliche principali, `BASE_URL` per cambiare host, exit 1 se ci sono violazioni; l'audit del front office (`npm run audit:fo`) ripete axe da ospite e da loggato ([testing](testing.md)). axe non basta: serve anche una passata a tastiera e con screen reader.

## Regole del tema (applicate nel codice o da rispettare nei nuovi componenti)

- **Struttura**: un `h1` per pagina, gerarchia `h2/h3` ordinata, landmark nativi (`header`, `nav` con `aria-label`, `main id="main-content"`, `footer`); `aria-labelledby` sulle sezioni con titolo (anche `h2` `sr-only` quando il titolo non si vede). L'attributo `lang` dell'`html` segue il locale corrente.
- **Skip link**: nel layout `components/layouts/main.blade.php`, primo elemento del `body`, testo tradotto `pub_theme::layout.skip_links.main_content.label`, visibile al focus (`sr-only focus:not-sr-only`). Non se ne aggiunge un secondo nei componenti.
- **Focus visibile**: regola globale in `resources/css/custom.css` su `a, button, input, select, textarea, summary, [tabindex]`: `outline: 3px solid` blu con `outline-offset: 3px` (`:focus-visible`). Non rimuovere `outline` senza un sostituto; i componenti interattivi possono aggiungere `focus-visible:ring-2 focus-visible:ring-red-500`.
- **Movimento**: `@media (prefers-reduced-motion: reduce)` in `custom.css` azzera durata e iterazioni di animazioni e transizioni e lo smooth scroll; le animazioni decorative della registrazione hanno una regola dedicata. Niente lampeggi > 3 Hz; elementi decorativi (blob, emoji, particelle) con `aria-hidden="true"`.
- **Tema scuro/chiaro**: l'interruttore (`components/ui/theme-toggle.blade.php`) ha `role="switch"` e `aria-checked` dinamico; la preferenza si legge da `localStorage` (`theme_dark`) con uno script inline nel layout prima del render per evitare il flash.
- **Menu**: il pulsante del menu mobile ha `aria-expanded`, `aria-controls` e un'etichetta tradotta (`pub_theme::navigation.toggle_menu`), Escape chiude i menu a tendina (Alpine); i link della pagina corrente usano `aria-current`.
- **Selettore lingua**: bottone con `aria-expanded`, lingua corrente marcata con `aria-current`; i ruoli `listbox/option` sono stati tolti perche' errati per dei link ([language-switcher](language-switcher.md)); su telefono mostra il nome della lingua, non solo un globo.
- **Immagini e icone**: `alt` descrittivo sulle immagini informative, `aria-hidden="true"` su SVG/icone decorative; i link-logo hanno nome accessibile (`aria-label`); icone come file SVG ([svg-icons-no-hardcoded-blade](svg-icons-no-hardcoded-blade.md)). I link `target="_blank"` dicono "si apre in una nuova scheda" (`gdpr::register.consents.opens_new_tab` per i consensi).
- **Form**: ogni campo ha una `label` programmatica (non solo placeholder), errori associati con `aria-describedby` e annunciati (`aria-live="polite"`), `autocomplete` corretto (name, email, current/new-password), niente affidamento sul solo colore per gli stati; messaggi di errore con l'etichetta visibile del campo.
- **Bersagli tattili**: minimo 44x44 px su telefono; nessuno scroll orizzontale a 320 px (controllato da `audit:fo`).
- **Pagine di errore** (403/404/419/429/500/503) tradotte e dentro il layout (`resources/views/errors/page.blade.php`), con `h1`.

## Contrasto: numeri da ricordare

Rapporti calcolati con la formula WCAG sui colori Tailwind del tema:

| Coppia | Rapporto | Esito testo normale (4.5:1) |
|---|---|---|
| bianco su `red-700` | 6,5:1 | passa |
| bianco su `red-600` | 4,8:1 | passa (e' il rosso dei pulsanti primari) |
| bianco su `red-500` | 3,8:1 | **non passa** (solo testo grande >= 18pt o 14pt grassetto, o elementi non testuali) |
| `slate-100` su `slate-900` | 16,3:1 | passa (AAA) |
| `slate-400` su `slate-800` | 5,7:1 | passa |
| `gray-400` su `slate-950` | 8,0:1 | passa (AAA) |
| `red-500` su `slate-900` | 4,7:1 | passa (per link/accenti su fondo scuro) |
| `red-400` su `slate-800` | 5,3:1 | passa |

Quindi: testo bianco su pulsante rosso solo con `red-600` o piu' scuro; `red-500` va bene come accento su fondo scuro, non come fondo di testo piccolo. Per gli accenti blu/rossi vedi [design-system](design-system.md).

## Checklist per un cambiamento visivo

- [ ] Tab attraverso tutti gli elementi: focus sempre visibile, ordine logico, skip link funziona
- [ ] Menu e selettore lingua usabili da tastiera, Escape chiude, `aria-expanded` si aggiorna
- [ ] Contrasti verificati (tabella sopra o DevTools); stati non solo di colore
- [ ] `prefers-reduced-motion` attivo: nessuna animazione essenziale
- [ ] Form con label, errori annunciati, `autocomplete`; link esterni segnalati
- [ ] `npm run a11y` senza violazioni e passata con screen reader (NVDA/VoiceOver) sulle pagine toccate

## Vedi anche

- [register-page](register-page.md), [authentication-ui-ux](authentication-ui-ux.md) — form accessibili
- [gdpr-compliance](gdpr-compliance.md), [seo-structured-data](seo-structured-data.md)
- [layouts](layouts.md), [language-switcher](language-switcher.md)
