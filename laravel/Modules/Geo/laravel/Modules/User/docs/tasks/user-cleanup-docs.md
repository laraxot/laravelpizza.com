# Task: User Docs Cleanup

## 📋 Obiettivo
Riorganizzare la mastodontica cartella docs del modulo User (550+ file) che contiene anni di analisi sovrapposte.

## 🚨 Problemi Identificati
- Ripetizioni infinite di analisi (es. `logout-blade-analysis-1.md`, `logout-blade-analysis.md`, `logout-blade-corrected-analysis.md`).
- File duplicati per conflitti Git non risolti (`dry-kiss-analysis-conflict-018b09.md`).
- File temporanei e log di coverage enormi (`coverage_full.txt` da 600kb).

## ✅ Checklist
- [ ] Eliminazione di tutti i file `.txt` di log pesanti (se non necessari per auditing storico).
- [ ] Consolidamento delle 10+ guide sul logout in un unico "Logout Architecture Guide".
- [ ] Rimozione sistematica dei duplicati `-1.md` e `-2.md`.
- [ ] Spostamento massivo in `archive/` di analisi risalenti al 2024 o precedenti.

## 🔗 Riferimenti
- [Index Documentazione](../00-index.md)
