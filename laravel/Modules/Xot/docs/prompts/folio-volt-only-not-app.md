---
title: "Anti-pattern: scomodare App FolioServiceProvider"
type: prompt
module: Xot
qmd: "anti-pattern App FolioServiceProvider FolioVolt only"
related:
  - ../bmad/stories/folio-owner-foliovolt-not-app-provider.story.md
  - ../../../../../docs/wiki/memories/folio-owner-foliovolt-only.md
---

# Anti-pattern: App Folio quando c’è FolioVolt

**Sbagliato:** registrare / estendere `app/Providers/FolioServiceProvider.php`
per montare pagine moduli.

**Corretto (FO):** solo `Cms/FolioVoltServiceProvider`.

**PTVX:** Cms assente → non inventare mini-FolioVolt in App né nei moduli dominio.
