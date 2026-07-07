# GitHub Actions per moduli e temi (CI)

## Scopo

Definire il set di GitHub Actions che ogni modulo e ogni tema deve avere nella propria cartella `.github/workflows`, per coerenza, qualità e visibilità (rendere virale).

## Struttura obbligatoria

```
Modules/<Modulo>/
  .github/
    workflows/
      semantic-release.yml         # npx semantic-release (canonico STORY-131)
      semantic-versioning.yml      # Tag semver opzionale (github-tag-action)
      update-changelog.yml         # CHANGELOG su evento release
      contributor-analytics.yml    # git-fame: LOC per contributor × estensione (STORY-355)
      roadmap-check.yml            # Verifica docs/roadmap.md (opzionale)
```

Per i temi: `Themes/<Tema>/.github/workflows/` con gli stessi file.

## semantic-versioning.yml (template modulo)

- **Trigger**: `workflow_dispatch`, push su `main` e `dev`.
- **Permessi**: `contents: write`.
- **Step**: checkout con `fetch-depth: 0`, poi `mathieudutour/github-tag-action@v6.2` con `release_branches: main,dev`.

Usare lo stesso contenuto degli altri moduli (es. Activity, User) per uniformità.

## semantic-release.yml

Vedi [semantic-release-template.md](./semantic-release-template.md). Scaffold: `bashscripts/ci/scaffold-module-github-workflows.sh`.

- **Trigger**: push su `main`, `master`, `dev`; `workflow_dispatch`.
- **Step**: checkout `fetch-depth: 0`, Node 20, install plugin SR, `npx semantic-release`.
- **Config**: `.releaserc.json` nella root del repo owner (o sottocartella in monorepo reusable).

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

## Contributor lines report (STORY-131)

Workflow pianificato a livello root: `contributor-lines-report.yml` + `bashscripts/ci/contributor-lines-report.mjs` (cloc + git numstat, grafici HTML artifact). Dettaglio: [STORY-131](../../../../../../docs/stories/STORY-131-github-semantic-release-contributor-analytics.md).

## Collegamenti

- [docs root – GitHub Actions moduli](../../../../../../docs/github-actions-modules.md)
- [github-actions-semantic-release-monorepo](../../../../../../docs/wiki/concepts/github-actions-semantic-release-monorepo.md)
- [Semantic versioning](../../../../../.cursor/skills/semantic-versioning/skill.md)
- [PHPStan CI](phpstan.md)
- [Links CI](links.md)

## Riepilogo moduli con semantic-versioning

Dopo l’allineamento, tutti i moduli e il tema Zero hanno almeno:
- `semantic-versioning.yml`
- `tag-version.yml` (dove usato semantic-release)
- `update-changelog.yml`
- `roadmap-check.yml`