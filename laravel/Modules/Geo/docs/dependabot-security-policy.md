# Dependabot & Security Policy

**Data:** 2026-05-26

## Overview

Ogni modulo e tema deve:
1. ✅ Monitorare security alerts via Dependabot
2. ✅ Mergiare patch/minor updates automaticamente
3. ✅ Revisionare major updates manualmente
4. ✅ Documentare vulnerabilità in SECURITY.md
5. ✅ Avere auto-merge configurato per patch (non-breaking)

---

## Configuration

### `.github/dependabot.yml` per root repo

```yaml
version: 2
updates:
  # Composer (PHP)
  - package-ecosystem: composer
    directory: "/laravel"
    schedule:
      interval: daily
      time: "04:00"
    open-pull-requests-limit: 10
    allow:
      - dependency-type: "direct"
      - dependency-type: "indirect"
    reviewers:
      - "marco76tv"
    auto-merge: true
    target-branch: "develop"

  # npm (Node.js)
  - package-ecosystem: npm
    directory: "/laravel/Modules/Xot"
    schedule:
      interval: daily
    open-pull-requests-limit: 10
    auto-merge: true
    target-branch: "develop"

  # GitHub Actions
  - package-ecosystem: "github-actions"
    directory: "/"
    schedule:
      interval: "weekly"
    open-pull-requests-limit: 5
```

---

## Processo

### 1. Controllare Alert Aperti

```bash
# Lista PR dependabot
gh pr list --app dependabot

# Dettagli di una PR
gh pr view <PR_NUMBER>

# Check security status
gh api repos/{owner}/{repo}/security/dependabot/alerts
```

### 2. Revisionare & Mergiare

- **Patch updates** (1.2.3 → 1.2.4): auto-merge ✅
- **Minor updates** (1.2.0 → 1.3.0): revisa, poi merge
- **Major updates** (1.0.0 → 2.0.0): revisa MOLTO bene, test completo

### 3. Documentare Vulnerabilità

Crea `SECURITY.md` in ogni modulo/tema:

```markdown
# Security Policy

## Vulnerabilità Risolte

### 2026-05 - CVSS 7.8 - Symfony XXE
- **Pacchetto:** symfony/http-foundation
- **Versione:** < 6.4.1
- **Fix:** Aggiornato a 6.4.2
- **Rimedio:** https://github.com/advisories/GHSA-xxxx-xxxx-xxxx

## Auto-Updates

Patche di sicurezza sono mergiate automaticamente.
Revisa le PR su GitHub se criticità detected.

## Report Security Issues

Email: security@provtv.it
```

---

## GitHub Actions Setup

Aggiungi a `.github/workflows/dependabot-auto-merge.yml`:

```yaml
name: Auto-merge Dependabot PR

on: pull_request

jobs:
  auto-merge:
    runs-on: ubuntu-latest
    if: dependabot.author && contains(github.event.pull_request.labels.*.name, 'dependencies')

    steps:
      - uses: fastify/github-action-merge-dependabot@v3.9.1
        with:
          github-token: ${{ secrets.GITHUB_TOKEN }}
          allow-major: false
```

---

## Systematics

**Weekly Check:**
1. `gh pr list --app dependabot` su ogni repo modulo/tema
2. Mergia patch (auto-merge farà il resto)
3. Revisa minor/major updates
4. Aggiorna SECURITY.md

**Mensile:**
- Audit delle vulnerabilità risolte
- Aggiorna documentazione
- Rivedi dipendenze outdated

---

## Link Importanti

- [Dependabot Docs](https://docs.github.com/en/code-security/dependabot)
- [Security Advisories](https://github.com/advisories)
- [Repository Security Tab](https://github.com/laraxot/module_dbforge_fila5/security)

---

**Next:** Applica in tutti i moduli e temi.
