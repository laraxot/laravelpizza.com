# kinetic ux checklist (laravelpizza)

## scopo

Rendere il sito **più coinvolgente e memorabile** usando motion e micro‑interazioni **come strumenti di comunicazione** (guida, feedback, orientamento), senza sacrificare:

- performance (Core Web Vitals)
- accessibilità (incl. `prefers-reduced-motion`)
- chiarezza del percorso utente

## principi (cosa sì)

Derivazione dalle fonti: [berger.team](https://www.berger.team/it/website/kinetisches-webdesign-bewegung-als-zentrales-designelement/), [evoluzioneinformatica.it](https://www.evoluzioneinformatica.it/2026/02/web-design-immersivo-nel-2026-cose-e-perche-sta-cambiando-il-modo-di-progettare-i-siti/), [sparkinweb.com](https://www.sparkinweb.com/post/micro-interazioni-sul-sito-quanto-sono-importanti/), [visibilia.net](https://www.visibilia.net/2025/01/a-cosa-servono-le-animazioni-web/).

- **motion = funzione**: ogni animazione deve essere collegata a uno scopo (feedback, gerarchia, orientamento, invito all’azione).
- **micro‑interazioni = controllo**: l’utente deve percepire che l’interfaccia “risponde” (hover/tap, loading, conferme).
- **percorso narrativo**: lo scroll e le transizioni possono diventare “racconto” (scrollytelling), ma la struttura deve restare rigorosa.
- **coerenza**: timing/easing/stili ripetibili (token/utility). Niente pattern nuovi “ad ogni pagina”.
- **performance come parte dell’esperienza**: motion fluido e leggero, niente scatti/ritardi.

## anti‑pattern (cosa no)

- animazioni “solo decorative” che non spiegano nulla e rubano attenzione
- motion che **disorienta** (elementi che appaiono/scompaiono senza contesto)
- animazioni pesanti o lente (l’immersività crolla se l’interfaccia non è fluida)
- parallax/3D “perché sì” (ha senso solo se utile al contenuto)
- stato duplicato (es. due sistemi diversi che controllano lo stesso menu)
- ignorare `prefers-reduced-motion` (accessibilità e comfort)

## checklist operativa (cosa deve avere il sito)

### motion & micro‑interazioni
- [ ] CTA con feedback chiaro (hover/tap) e focus visible
- [ ] card/lista eventi con micro‑interazioni coerenti (hover, press, highlight)
- [ ] transizioni tra sezioni leggere (dissolvenza/slide breve) e coerenti
- [ ] feedback di caricamento/stato (loading, empty state, errore) non invasivo

### performance & stabilità (Core Web Vitals)
- [ ] LCP/CLS/INP misurabili e tracciati (prima/dopo)
- [ ] animazioni basate su `transform`/`opacity` (evitare layout thrash)
- [ ] lazy loading intelligente per media pesanti (immagini/canvas/effetti)

### accessibilità
- [ ] `prefers-reduced-motion`: ridurre/disabilitare motion non essenziale
- [ ] navigazione tastiera per menu/dropdown + focus states visibili
- [ ] contrasto e leggibilità invariati anche durante animazioni

### mobile-first reale
- [ ] motion calibrato su touch (tap target, no hover-only)
- [ ] priorità contenuti differenziata su schermi piccoli

## dove si implementa (quick map)

- Tema pubblico: `laravel/Themes/Meetup/`
- Checklist tema specifica: `../laravel/Themes/Meetup/docs/kinetic-ux-checklist.md`
- Regole Xot (framework): `../laravel/Modules/Xot/docs/kinetic-ux-checklist.md`

