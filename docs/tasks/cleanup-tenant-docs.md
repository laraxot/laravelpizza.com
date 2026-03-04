# Task: Cleanup Tenant Docs

## 📋 Obiettivo
Ripulire la directory `docs/` del modulo Tenant (172 file), eliminando file duplicati e versioni ridondanti.

## 🚨 Problemi Identificati
- 36 file nella directory `archive/`.
- File duplicati con suffissi `-1.md`.
- Molte bozze di analisi sparse.

## ✅ Checklist
- [ ] Identificare e rimuovere file con suffisso `-1.md` se già presenti nella versione principale.
- [ ] Verificare il contenuto di `analysis/` e consolidare se utile.
- [ ] Rimuovere file corrotti o con marker di conflitto Git (se presenti).
- [ ] Sfoltire `archive/` mantenendo solo documentazione di pattern storici rilevanti.

## 🔗 Riferimenti
- [Roadmap Tenant](../roadmap.md)
