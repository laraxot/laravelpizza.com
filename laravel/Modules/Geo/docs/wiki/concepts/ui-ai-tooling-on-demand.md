# Tooling UI/AI on demand per il modulo Geo

## Scopo

Il modulo Geo possiede componenti visuali complessi (`map-lit`, marker, cluster, popup). Gli agenti usano strumenti UI/AI on demand; **non** diventano dipendenze runtime.

## Matrice verificata (2026-06-03, sessione llm-wiki 998–1010)

| Strumento | Verifica comando | Esito |
|---|---|---|
| Impeccable | `npx impeccable detect` su CSS map | OK |
| Playwright MCP | `@playwright/mcp@0.0.75`, TodoMVC + `127.0.0.1:8000/robots.txt` | OK; `/it/` ~11s SSE vuoto (pagina pesante) — usare test Geo Playwright |
| UI UX Pro Max | `search.py "map" --design-system -p Fixcity` | OK |
| Flowbite MCP | `npx flowbite-mcp --help` | OK server |
| Laravel Boost | `php artisan boost:mcp --help` | OK; stdio attende client |
| daisyUI Blueprint | `npx daisyui-blueprint` senza LICENSE | Bloccato licenza |
| Windframe | `curl https://mcp.windframe.dev/mcp` | 401 senza OAuth |
| Tailkit | — | Richiede licenza OAuth |
| Tailwind MCP | — | Prodotto Pinterest, non CSS |
| Tailkits article | — | Panoramica comparativa MCP libraries |

## Quando usare cosa (map-lit)

| Task | Strumento |
|---|---|
| Popup/marker polish (intenzionale, no slop) | Skill `frontend-design` + overlay PA — [frontend-design-fixcity-overlay.md](../../../../../Themes/Sixteen/docs/wiki/concepts/frontend-design-fixcity-overlay.md) |
| Hover cluster, GPS, marker count | Playwright test `Modules/Geo/tests/Playwright/` |
| Audit contrasto/typography legenda | Impeccable |
| Brainstorm palette stati marker | UI UX Pro Max `--design-system` |
| Esempi dropdown/filter | Flowbite MCP (solo riferimento) |

## Collegamenti

- Hub root: `docs/wiki/concepts/ui-ai-tooling-on-demand-matrix.md`
- Tema Sixteen: `Themes/Sixteen/docs/wiki/concepts/ui-ai-tooling-on-demand.md`
- STORY-126: `docs/stories/STORY-126-ui-ai-tooling-on-demand-second-brain.md`
- Playwright MCP: `docs/wiki/concepts/playwright-mcp-browser-automation.md`
