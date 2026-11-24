# Root files hygiene

## 2026-08-28

- Bonifica root: rimossi 4 file test/sync (`sync-test-file.md`, `SYNC_TEST_FILE.md`, `test-bb.md`, `test.md`)
- Gate: `bash bashscripts/tools/audit-module-root-hygiene.sh Seo` → PASS
- Policy: zero `.txt`, max 6 `.md` — [XOT-5.46](../../Xot/docs/stories/5.46.module-root-max-six-md-zero-txt.story.md)

## 2026-07-08 16:51

- created `Seo.code-workspace` as the single canonical root workspace file.
