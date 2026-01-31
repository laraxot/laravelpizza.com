# Task: Documentare Actions Framework - Xot

**Modulo**: Xot
**Priorita'**: Bassa
**Completamento**: 20%
**Data**: 2026-01-30

---

## Descrizione

Il modulo Xot ha 80+ Actions organizzate per dominio ma manca un documento di riferimento che le descriva tutte con input/output/uso.

## Categorie Actions da Documentare

| Categoria | N. Actions | Stato Doc |
|-----------|-----------|-----------|
| File (Asset, Copy, ViewPath) | ~10 | Parziale |
| Array (SaveJson, SavePhp, Diff) | ~8 | Mancante |
| Cast (SafeString, SafeInt, SafeBool) | ~6 | Mancante |
| Export (Pdf, Xls) | ~5 | Parziale |
| Config (TenantConfig) | ~4 | Mancante |
| Filament (GenerateForm, GenerateTable) | ~8 | Parziale |
| Model (GetByType, GetClass) | ~10 | Mancante |
| Import (ImportCsv) | ~3 | Mancante |
| Mail (SendMail) | ~2 | Mancante |

## Deliverable

Creare `docs/actions-reference.md` con:
- Elenco completo delle actions
- Per ogni action: namespace, input, output, esempio d'uso
- Pattern di utilizzo con Spatie QueueableAction
- Best practices per creare nuove actions

## Criteri di Completamento

- [ ] Documento `actions-reference.md` creato
- [ ] Tutte le 80+ actions elencate
- [ ] Almeno 20 actions con esempio d'uso
- [ ] Pattern documentato per nuove actions
