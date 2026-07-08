# Root files hygiene

## 2026-07-08 16:48

Root normalized to keep no `.txt` files, at most four Markdown files, and a single module/theme workspace file named after the directory.

- moved `CHANGELOG.MD` to `docs/root-md-files/CHANGELOG.MD` (root markdown limit is four files)

## 2026-07-08 16:51

- created `Xot.code-workspace` as the single canonical root workspace file.

## 2026-07-08 (root hygiene follow-up, agente docs)

- Il flat dump in `docs/root-md-files/` (128 file) è stato riorganizzato tematicamente:
  - 4 duplicati esatti di README/CHANGELOG/LICENSE già presenti in root eliminati (`changelog.md`, `CHANGELOG.MD`, `license.md`, `license-renamed.md` — nessun contenuto univoco perso, verificato con `diff`).
  - 21 file con match tematico chiaro spostati in `docs/best-practices/`, `docs/quality/`, `docs/tools/`, `docs/testing/`, `docs/theme/`, `docs/packages/`.
  - I restanti 103 file (appunti di studio generici, scollegati da Xot) spostati in `docs/legacy-notes/` (nuova cartella).
  - Cartella `docs/root-md-files/` rimossa (vuota).
  - `docs/root-txt-files/` (vuota, mai popolata — i .txt erano già stati rinominati .md a monte) rimossa.
  - Vedi `docs/INDEX.md` sezione "Legacy Notes" per dettagli e nota sui contenuti obsoleti.
- **Non toccato**: `docs/root-code-workspace-files/` (contiene `_xot.code-workspace` e `_activity.code-workspace`, identici) — la ricreazione del file `.code-workspace` canonico in root è demandata a un altro agente che sta consolidando la convenzione `<Modulo>.code-workspace` (PascalCase) su tutti i moduli/temi. Non creare `_xot.code-workspace`.
