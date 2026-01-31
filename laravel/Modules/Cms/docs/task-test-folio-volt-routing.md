# Task: Test Folio/Volt Routing - Cms

**Modulo**: Cms
**Priorita'**: Media
**Completamento**: 40%
**Data**: 2026-01-30

---

## Descrizione

Il FolioVoltServiceProvider gestisce routing multi-lingua con Folio ma mancano test end-to-end per verificare che le pagine vengano servite correttamente.

## Test da Implementare

- [ ] Test che `/it/{slug}` serve la pagina corretta
- [ ] Test che `/en/{slug}` serve la traduzione inglese
- [ ] Test che pagina inesistente ritorna 404
- [ ] Test che content_blocks vengono renderizzati
- [ ] Test che middleware viene applicato
- [ ] Test che locale viene impostato correttamente

## Criteri di Completamento

- [ ] 6+ test per routing Folio
- [ ] Test per traduzione content blocks
- [ ] Tutti i test passano
