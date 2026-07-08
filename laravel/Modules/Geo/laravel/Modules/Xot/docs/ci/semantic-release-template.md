# Template semantic-release (moduli e temi)

## Scopo

Un solo stack **semantic-release** + **Conventional Commits** per ogni repo owner (`module_*_fila5`, `theme_*_fila5`) e orchestrazione monorepo su `base_fixcity_fila5`.

## Golden reference

- Workflow: `laravel/Modules/Gdpr/.github/workflows/semantic-release.yml`
- Config: `laravel/Modules/Lang/.releaserc.json` (changelog + git)
- Template: `bashscripts/ci/templates/github/workflows/`

## Scaffold

```bash
chmod +x bashscripts/ci/scaffold-module-github-workflows.sh
./bashscripts/ci/scaffold-module-github-workflows.sh laravel/Modules/Geo geo
./bashscripts/ci/scaffold-module-github-workflows.sh laravel/Themes/TwentyOne theme-twentyone
```

Crea:

| File | Ruolo |
|------|--------|
| `.github/workflows/semantic-release.yml` | `npx semantic-release` su push `main`/`master`/`dev` |
| `.github/workflows/update-changelog.yml` | Aggiorna `CHANGELOG.md` su evento `release` |
| `.github/workflows/semantic-versioning.yml` | Tag semver opzionale (`github-tag-action`) |
| `.releaserc.json` | Plugin analyzer, notes, changelog, github, git |
| `CHANGELOG.md` | Stub iniziale |

## Repo standalone vs monorepo

- **Repo modulo/tema:** i workflow in `.github/workflows/` del modulo **partono** su push al repo owner.
- **Monorepo base:** i workflow sotto `laravel/Modules/*/.github` **non** partono da GitHub; usare `.github/workflows/semantic-release-monorepo.yml` (matrix + `reusable-semantic-release.yml`).

`semantic-versioning.yml` nel template **non** usa path `Modules/X/**` — valido solo nel repo corrente.

## Fixcity root

- `.releaserc.json` con `tagFormat: fixcity-v${version}`
- Legacy: `.github/workflows/semantic-release.yml` (git-auto-semver) — deprecato; canonico: `semantic-release-monorepo.yml`

## Deprecazioni

- `Fixcity/.github/workflows/release.yml`: solo `workflow_dispatch`; release automatica su `semantic-release.yml`.

## Contributor analytics (solo base)

- Script: `bashscripts/ci/contributor-lines-report.mjs`
- Workflow: `.github/workflows/contributor-lines-report.yml`
- Output locale/artifact: `reports/contributor-lines.html` (gitignored)

## Collegamenti

- [github-actions-modules.md](./github-actions-modules.md)
- [STORY-131](../../../../docs/stories/STORY-131-github-semantic-release-contributor-analytics.md)
- [github-actions-semantic-release-monorepo.md](../../../../docs/wiki/concepts/github-actions-semantic-release-monorepo.md)
