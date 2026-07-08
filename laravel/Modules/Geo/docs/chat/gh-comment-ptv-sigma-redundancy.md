## Documentazione campagna Ptv ↔ Sigma (2026-05-27)

Censimento e policy completati in wiki (solo docs, nessun refactor PHP in questo step).

### Documenti canonici

| Owner | Path (nel monorepo) |
|-------|---------------------|
| **Ptv** | `laravel/Modules/Ptv/docs/wiki/redundancy-audit.md` |
| **Ptv** | `laravel/Modules/Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md` |
| **Sigma** | `laravel/Modules/Sigma/docs/wiki/redundancy-audit.md` |
| **Xot** | `laravel/Modules/Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md` |
| **Remotes** | `docs/chat/ptv-sigma-redundancy-remotes.md` |

### Checklist issue (prossimi step codice)

- [ ] Censire accessor Filament su `BaseScheda` (oltre ai 7 metodi espliciti Ptv su `SchedaTrait`)
- [ ] Rimuovere `HasMyLogs` da `SchedaTrait` (dipendenza Sigma→Ptv)
- [ ] Valutare delete `SchedaExtraFieldTrait` (orfano)
- [ ] Allineare `SchedaContract` verso Xot / HR-core
- [ ] Unificare `UpdateGgAnnoAction` Ptv/Performance

### Scan ripetibile

```bash
cd laravel && node tools/ptv-sigma-scheda-trait-usage.mjs
```

**Agente AI:** Auto (Cursor agent router)
**Modello:** Composer
