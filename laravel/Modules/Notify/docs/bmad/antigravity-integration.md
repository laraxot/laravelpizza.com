# antigravity e bmad method: integrazione e contesto fixcity

## scopo

Chiarire la relazione tra **Google Antigravity** (IDE/agent-first), il template community **[antigravity-bmad-config](https://github.com/salacoste/antigravity-bmad-config)** e il modo in cui **FixCity** usa già BMAD (`_bmad/`, skill Cursor, artefatti in `_bmad-output/`).

Evita confusione: **non sono due installazioni obbligatorie**; sono **due ambienti** (Antigravity vs Cursor/Windsurf) che possono condividere la stessa filosofia BMAD.

## cosa offre il template antigravity (salacoste)

- workflow in `.agent/workflows/` con **slash command** (`/pm`, `/architect`, `/dev`, `/qa`, …)
- `AGENTS.md` orientato a Codex/agent
- script `.gemini/transpose_bmad.py` per rigenerare i workflow da `.bmad-core/`
- prerequisito: cartella **`.bmad-core/`** (agenti/task/template BMAD) oppure installazione via `npx bmad-method install -f` (vedi README del template)

**Fonte**: repository `salacoste/antigravity-bmad-config` (README ufficiale).

## cosa usa questo repository (fixcity)

| Aspetto | FixCity |
|--------|---------|
| installazione BMAD | `npx bmad-method install` (vedi [guida](../guides/bmad-method-setup.md)) |
| cartella core | **`_bmad/`** (non `.bmad-core/` nel root) — convenzione BMAD-METHOD nel progetto |
| artefatti | **`_bmad-output/`** |
| skill in Cursor | `.agents/skills/` (pattern `bmad-*`) |
| workflow Antigravity | **non presente** (nessuna `.agent/workflows/` in questo repo) |

Quindi: **Antigravity non è “installato” nel repo** perché è un **prodotto IDE esterno**. Se lavori solo in Cursor, usi skill e `_bmad/`; se usi Antigravity in parallelo, puoi **clonare il template** in un altro clone o **mergiare** manualmente `.agent/workflows/` seguendo il README del template e il tuo `.bmad-core`/`_bmad`.

## quando ha senso aggiungere il template antigravity

- team che usa **Gemini / Antigravity** per `/pm` … `/qa` e vuole gli stessi ruoli BMAD
- necessità di **slash command** nativi in quell’IDE

**Non** è necessario per compilare Laravel o per il tema Sixteen.

## risorse esterne (studio)

- [BMAD-METHOD — repository](https://github.com/bmad-code-org/BMAD-METHOD/)
- [Comandi di riferimento](https://docs.bmad-method.org/reference/commands/)
- Discussioni e articoli (blog, forum Cursor, Medium) sono utili per **contesto** e varianti; la **fonte operativa** resta docs ufficiali + `_bmad/` locale.

## link interni (canonici)

- [setup e configurazione](setup-guide.md)
- [quick reference](quick-reference.md)
- [guida installazione completa](../guides/bmad-method-setup.md)

## tema sixteen (prompt)

- `laravel/Themes/Sixteen/docs/prompts/bmad.txt` — elenco link e promemoria; **non duplicare** qui la guida: puntare a questa cartella `docs/bmad/`.
