# GitHub Actions Setup — Semantic Versioning & Auto-Release

**Data:** 2026-05-26

## Overview

Ogni modulo e tema deve avere:
1. ✅ **GitHub Action** per semantic versioning
2. ✅ **Auto-changelog** generation
3. ✅ **Auto-release** su GitHub
4. ✅ **Version bump** in package.json/composer.json

---

## Setup Rapido (Per Modulo/Tema)

### 1. Crea `.github/workflows/semantic-release.yml`

```yaml
name: Semantic Release

on:
  push:
    branches: [main, develop]

jobs:
  release:
    runs-on: ubuntu-latest
    permissions:
      contents: write
      packages: write

    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 20

      - run: npm install -g semantic-release @semantic-release/changelog @semantic-release/git
      - run: semantic-release
        env:
          GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
```

### 2. Crea `.releaserc.json` in root modulo/tema

```json
{
  "branches": ["main", "develop"],
  "plugins": [
    "@semantic-release/commit-analyzer",
    "@semantic-release/release-notes-generator",
    "@semantic-release/changelog",
    [
      "@semantic-release/git",
      {
        "assets": ["CHANGELOG.md", "package.json"],
        "message": "chore(release): bump version to ${nextRelease.version}"
      }
    ],
    [
      "@semantic-release/github",
      {
        "releasedLabels": ["released"]
      }
    ]
  ]
}
```

### 3. Struttura di Versioning

**Commit format:**
```
feat: new feature          → MINOR (0.1.0 → 0.2.0)
fix: bug fix               → PATCH (0.1.0 → 0.1.1)
BREAKING CHANGE: info      → MAJOR (0.1.0 → 1.0.0)
docs: documentation        → no version bump
```

**Esempio:**
```bash
git commit -m "feat(Xot): add polymorphic relations helper

This new feature allows..."  # → v1.2.0

git commit -m "fix: static method context

BREAKING CHANGE: XotBaseResourceTable now requires..."  # → v2.0.0
```

---

## Implementazione Progressiva

**Fase 1 (Oggi):** Modulo Xot + 3 Temi  
**Fase 2 (Week 1):** Lang, User modules  
**Fase 3 (Week 2):** Rimanenti moduli  

---

## Vantaggi

- ✅ Version automatica basata su commit message
- ✅ CHANGELOG.md auto-generato
- ✅ GitHub Release auto-creato
- ✅ Traceabilità completa

---

## Template Modulo

Copia questa struttura in ogni modulo/tema:

```
Modulo/Tema/
├── .github/
│   └── workflows/
│       └── semantic-release.yml
├── .releaserc.json
├── CHANGELOG.md
├── package.json  (versione)
├── composer.json (versione)
└── README.md     (link a releases)
```

---

## Verifica Setup

```bash
# Test locale
npx semantic-release --dry-run

# Push e controlla GitHub Actions
git push origin main
```

---

## Best Practices

- ✅ Sempre usa commit message strutturate
- ✅ Usa `feat:`, `fix:`, `docs:`, `refactor:` prefissi
- ✅ Aggiungi `BREAKING CHANGE:` per major versions
- ✅ Revisa CHANGELOG.md prima di release
- ✅ Usa GitHub Releases per comunicare change ai maintainer

---

**Next:** Implementa in Xot, poi scale ai rimanenti moduli.
