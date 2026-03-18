# kinetic ux checklist (xot)

## scopo

Definire il “contratto” di **motion e micro‑interazioni** per i progetti Laraxot:

- motion come **strumento di UX** (feedback/orientamento/gerarchia), non decorazione
- coerenza (pattern ripetibili) e performance come requisito
- accessibilità (in particolare `prefers-reduced-motion`) come parte del design

Riferimenti esterni: [berger.team](https://www.berger.team/it/website/kinetisches-webdesign-bewegung-als-zentrales-designelement/), [evoluzioneinformatica.it](https://www.evoluzioneinformatica.it/2026/02/web-design-immersivo-nel-2026-cose-e-perche-sta-cambiando-il-modo-di-progettare-i-siti/), [sparkinweb.com](https://www.sparkinweb.com/post/micro-interazioni-sul-sito-quanto-sono-importanti/), [visibilia.net](https://www.visibilia.net/2025/01/a-cosa-servono-le-animazioni-web/).

## regole (framework-level)

- **motion deve essere misurabile**: ogni “pacchetto” di micro‑interazioni deve avere una metrica target (es. INP, CTR CTA, bounce).
- **no state duplication**: un comportamento UI deve avere una sola “source of truth” (es. Alpine *o* JS, non entrambi per lo stesso componente).
- **accessibilità by default**:
  - implementare `prefers-reduced-motion`
  - focus visible e tastiera per elementi interattivi
- **performance by design**:
  - animazioni su `transform/opacity`
  - lazy load per asset non immediati

## dove documentare

- root progetto (visione e checklist): `../../../../docs/kinetic-ux-checklist.md`
- tema pubblico (implementazione concreta): `../../../Themes/Meetup/docs/kinetic-ux-checklist.md`

