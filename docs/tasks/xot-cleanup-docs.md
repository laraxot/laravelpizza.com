# Task: Xot Docs Cleanup

## 📋 Obiettivo
Riorganizzare l'enorme archivio del modulo Xot (780+ file) per eliminare il rumore e facilitare l'onboarding.

## 🚨 Problemi Identificati
- Frammentazione estrema (es. `architecture-violations-and-fixes-1.md` vs `...fixes.md`).
- Backup di conflitti merge ovunque (`git-conflicts-resolution-conflict-...`).
- File di log temporanei e report di autoload obsoleti.

## ✅ Checklist
- [ ] Eliminazione di tutti i file derivanti da conflitti Git non risolti (`~...`, `...conflict...`).
- [ ] Consolidamento delle analisi architettoniche in un unico "Reference Guide".
- [ ] Rimozione di file con 1 byte o contenuto triviale.
- [ ] Spostamento massivo in `archive/consolidated/` di tutto il materiale pre-2025.

## 🔗 Riferimenti
- [Index Documentazione](../00-index.md)
