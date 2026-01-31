# Task: Implementare Versioning Pagine - Cms

**Modulo**: Cms
**Priorita'**: Bassa
**Completamento**: 0%
**Data**: 2026-01-30

---

## Descrizione

Le pagine CMS non hanno versioning. Aggiungere revisioni per permettere rollback e audit trail dei contenuti.

## Approccio

1. Aggiungere tabella `page_revisions` con foreign key a pages
2. Salvare snapshot JSON ad ogni modifica
3. Implementare action `RevertPageToRevisionAction`
4. Widget Filament per visualizzare cronologia revisioni

## Criteri di Completamento

- [ ] Migration per page_revisions
- [ ] Action di salvataggio revisione automatico
- [ ] Action di revert
- [ ] UI Filament per cronologia
