# Roadmap Tema Meetup - 2026-01-30

**Tema**: Meetup (Frontend Premium LaravelPizza)
**Scopo**: Tema frontend premium per conversione laravelpizza.com - Folio routing, Volt components, Tailwind CSS, Alpine.js. Design moderno, engaging, clickbait-worthy.
**Stato Generale**: 55%
**Documentazione**: 138 docs

---

## Stato Attuale

Il tema Meetup e' la faccia pubblica di LaravelPizza. Usa:
- **Folio** per routing file-based (NO controllers)
- **Volt** per componenti dichiarativi
- **Tailwind CSS** per styling utility-first
- **Alpine.js** per interazioni JavaScript
- **Vite** per build pipeline
- Layout hierarchy: `x-layouts.main` -> `x-layouts.app` -> pagine

---

## Tasks

| # | Task | File | Priorita' | % |
|---|------|------|-----------|---|
| 1 | Completare pagine principali | [task-pagine-principali.md](task-pagine-principali.md) | Critica | 40% |
| 2 | Implementare block components mancanti | [task-block-components.md](task-block-components.md) | Alta | 30% |
| 3 | Design system e animazioni | [task-design-system.md](task-design-system.md) | Alta | 20% |
| 4 | Responsive e performance | [task-responsive-performance.md](task-responsive-performance.md) | Media | 30% |
| 5 | Social sharing e viralita' | [task-social-sharing.md](task-social-sharing.md) | Media | 10% |
| 6 | Consolidare documentazione (138 file) | [task-consolidare-documentazione.md](task-consolidare-documentazione.md) | Bassa | 15% |

---

## Note

- Il tema deve essere WOW - non solo funzionale
- Seguire pattern CMS blocks per tutte le pagine
- npm run build && npm run copy dopo ogni modifica CSS/JS
- NO controller tradizionali per frontend
