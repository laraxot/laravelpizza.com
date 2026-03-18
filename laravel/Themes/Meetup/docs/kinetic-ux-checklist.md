# kinetic ux checklist (meetup theme)

## scopo

Applicare kinetic/immersive design al tema `Meetup` in modo **riusabile** e **misurabile**:

- migliorare coinvolgimento e percezione qualità
- guidare la navigazione (orientamento, gerarchia, feedback)
- preservare performance e accessibilità

Fonti di riferimento: [berger.team](https://www.berger.team/it/website/kinetisches-webdesign-bewegung-als-zentrales-designelement/), [evoluzioneinformatica.it](https://www.evoluzioneinformatica.it/2026/02/web-design-immersivo-nel-2026-cose-e-perche-sta-cambiando-il-modo-di-progettare-i-siti/), [sparkinweb.com](https://www.sparkinweb.com/post/micro-interazioni-sul-sito-quanto-sono-importanti/), [visibilia.net](https://www.visibilia.net/2025/01/a-cosa-servono-le-animazioni-web/).

## regole tema (vincoli che non si discutono)

- frontoffice = Folio/Volt (no controller/route manuali)
- namespace tema = `pub_theme::`
- url localizzati = `LaravelLocalization::localizeUrl()`
- niente svg inline nelle blade (usare svg file + `<x-filament::icon .../>`)
- motion deve rispettare `prefers-reduced-motion`

## checklist operativa

### global (layout/header/footer)
- [ ] menu mobile con **stato unico** (evitare doppio controllo Alpine + JS)
- [ ] language switcher con feedback (apertura/chiusura, focus, aria) coerente
- [ ] theme toggle con feedback immediato e focus visible

### blocchi (cards e liste)
- [ ] hover/tap micro‑motion coerente su card eventi (elevation/outline/shine leggero)
- [ ] transizioni leggere per filtri lista eventi (stati: active/disabled/loading)
- [ ] empty state “utile” (non solo estetico): guida l’utente al prossimo passo

### accessibilità
- [ ] `prefers-reduced-motion`: disabilitare o ridurre:
  - canvas/particles
  - animazioni non informative
- [ ] focus states visibili e navigazione tastiera per menu e dropdown

### performance (CWV)
- [ ] animazioni su `transform`/`opacity` (no jank)
- [ ] lazy load per media pesanti e componenti non immediately-visible

## dove implementare

- layout: `resources/views/components/layouts/main.blade.php`, `resources/views/components/layouts/app.blade.php`
- header/footer: `resources/views/components/sections/header/v1.blade.php`, `resources/views/components/sections/footer/v1.blade.php`
- blocks: `resources/views/components/blocks/**`
- css: `resources/css/app.css`
- js: `resources/js/app.js` (+ `resources/js/particles.js`)

## collegamenti

- checklist globale: `../../../../docs/kinetic-ux-checklist.md`
- regole framework (Xot): `../../../Modules/Xot/docs/kinetic-ux-checklist.md`
- docs-first workflow: `docs-first-workflow.md`

