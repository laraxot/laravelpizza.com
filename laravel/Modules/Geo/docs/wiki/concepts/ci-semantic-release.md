# ci — semantic release modulo geo

## scopo

Il modulo Geo partecipa al release monorepo con tag dedicati `geo-v*`.

## file locali

| File | Ruolo |
|------|--------|
| `.releaserc.json` | tagFormat `geo-v${version}`, changelog, github release |
| `CHANGELOG.md` | Generato/aggiornato da semantic-release |

## workflow (eseguito dalla root)

[`semantic-release-monorepo.yml`](../../../../../.github/workflows/semantic-release-monorepo.yml) → `working-directory: laravel/Modules/Geo`

## contributor report

Scope `geo` in [`contributor-analytics.yml`](../../../../../.github/workflows/contributor-analytics.yml) → `docs/outputs/contributor-analytics/geo-by-extension.md`

## collegamenti

- [semantic-release-monorepo.md](../../../../../docs/wiki/ci/semantic-release-monorepo.md)
- [STORY-130](../../../../../docs/stories/STORY-130-semantic-release-contributor-analytics-ci.md)

## github (module_geo_fila5)

- Issue release/CI: aprire o collegare su [module_geo_fila5](https://github.com/laraxot/module_geo_fila5/issues)
- Discussion: [module_geo_fila5 discussions](https://github.com/laraxot/module_geo_fila5/discussions)
