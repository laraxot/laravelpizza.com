---
title: "Cross-module dependency rules"
type: rule
tags: [module, dependency, architecture, coupling]
created: 2026-07-08
updated: 2026-07-08
qmd: "module dependency no cross coupling ui geo architecture separation"
issues: []
discussions: []
related:
  - module-root-cleanup-rules.md
  - ../../../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md
---

# Cross-module dependency rules

## Perché

I moduli devono essere indipendenti e disaccoppiati. Un modulo non deve dipendere da un altro modulo specifico, altrimenti si crea accoppiamento orizzontale che impedisce di disabilitare moduli non necessari.

## Regole obbligatorie

### Commit su moduli separati

- Ogni modulo (`laravel/Modules/<Modulo>/`) è un repository Git autonomo
- Dopo aver modificato file in un modulo, bisogna **sempre** andare in quella directory e fare `git commit && git push`
- Il commit nel root repo non basta — i moduli hanno remoto proprio
- Verifica: `ls -la Modules/<Modulo>/.git` per confermare che è un repo separato

### Nessuna dipendenza orizzontale tra moduli

- **VIETATO**: un modulo che importa classi, componenti o servizi da un altro modulo specifico
- Eccezione: `Modules\Xot` è il modulo base condiviso (servizi trasversali, utilities)

### UI non deve dipendere da Geo

- Componenti specifici di mapping/geografici appartengono al modulo **Geo**
- UI può avere componenti generici ma non deve referenziare classi da `Modules\Geo`
- Se un componente UI riguarda mappe/coordinate, va nel modulo Geo oppure rinominato con suffisso `.old`

### Regola generale

- Ogni funzionalità vive nel modulo che la possiede semanticamente
- Se il modulo non serve nel progetto, tutto il suo codice dev'essere auto-contenuto e rimovibile senza effetti collaterali
- Controllo: prima di aggiungere un `use Modules\...` in un modulo, chiedersi se crea una dipendenza verso un modulo che potrebbe non essere installato
