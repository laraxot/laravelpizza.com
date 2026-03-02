# GitHub Actions per moduli e temi (CI)

## Scopo

Definire il set di GitHub Actions che ogni modulo e ogni tema deve avere nella propria cartella `.github/workflows`, per coerenza, qualità e visibilità (rendere virale).

## Struttura obbligatoria

```
Modules/<Modulo>/
  .github/
    workflows/
      semantic-versioning.yml   # Tag automatico su main/dev
      tag-version.yml          # Semantic-release (main/master)
      update-changelog.yml     # CHANGELOG su release
      roadmap-check.yml       # Verifica docs/roadmap.md
```

Per i temi: `Themes/<Tema>/.github/workflows/` con gli stessi file.

## semantic-versioning.yml (template modulo)

- **Trigger**: `workflow_dispatch`, push su `main` e `dev`.
- **Permessi**: `contents: write`.
- **Step**: checkout con `fetch-depth: 0`, poi `mathieudutour/github-tag-action@v6.2` con `release_branches: main,dev`.

Usare lo stesso contenuto degli altri moduli (es. Activity, User) per uniformità.

## tag-version.yml

- **Trigger**: push su `main` e `master`.
- **Condizione**: escludere commit con messaggio `[release]`.
- **Step**: checkout, setup Node 20, npm install semantic-release + plugin, npx semantic-release.
- **Secrets**: `GH_TOKEN` (o `GITHUB_TOKEN`) per push tag.

## update-changelog.yml

- **Trigger**: `release` types `released`.
- **Step**: checkout main, stefanzweifel/changelog-updater-action con `latest-version` e `release-notes` dall’evento release, git-auto-commit su CHANGELOG.md.

## roadmap-check.yml

- **Trigger**: pull_request su `docs/roadmap.md` e `docs/roadmap/**`, push su main/master.
- **Step**: checkout, script che verifica esistenza di `docs/roadmap.md` e in caso contrario emette warning.

## Set esteso (virale)

- **phpstan.yml**: analisi PHPStan dal root Laravel sul path del modulo.
- **run-tests.yml**: `php artisan test` con filter sul modulo o path dei test.
- **quality.yml**: composizione di Pint, PHPStan, test.
- **dependabot-auto-merge.yml**: merge automatico dipendenze secondo policy.

## Build provenance (SLSA)

Per attestazioni di build (opzionale):

- Aggiungere permessi: `id-token: write`, `attestations: write`, `artifact-metadata: write`.
- Step: build artifact (es. `tar -czf module-artifact.tgz .`), poi `actions/attest-build-provenance@v3` con `subject-path`.

Vedi skill semantic-versioning per il template completo con attestation.

## Collegamenti

- [docs root – GitHub Actions moduli](../../../../../../../../../docs/github-actions-modules.md)
- [Semantic versioning](../../../../../.cursor/skills/semantic-versioning/skill.md)
- [PHPStan CI](phpstan.md)
- [Links CI](links.md)

## Riepilogo moduli con semantic-versioning

Dopo l’allineamento, tutti i moduli e il tema Zero hanno almeno:
- `semantic-versioning.yml`
- `tag-version.yml` (dove usato semantic-release)
- `update-changelog.yml`
- `roadmap-check.yml`
