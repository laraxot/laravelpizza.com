# Task: Cleanup Redundant Files (UI Module)

## 📋 Obiettivo
Ripulire il modulo UI da file di backup, duplicati e file temporanei che creano rumore e potenziali conflitti.

## 🚨 Problemi Identificati
- File con estensione `.bak`, `.old`, `.disabled`, `.to_geo`.
- File che differiscono solo per il case (es. `TimeclockWidget.php` vs `TimeClockWidget.php`).
- Documentazione duplicata o obsoleta in `docs/archive/`.

## ✅ Checklist
- [ ] Identificare tutti i file `.bak`, `.old`, `.disabled`, `.to_geo` nel modulo UI.
- [ ] Verificare se il contenuto di questi file è già presente nelle versioni attive.
- [ ] Rimuovere i file ridondanti.
- [ ] Identificare conflitti di naming case-sensitive tramite script.
- [ ] Risolvere i conflitti mantenendo le versioni conformi a PascalCase.
- [ ] Verificare che il sistema continui a funzionare dopo la pulizia.

## 🔗 Riferimenti
- [Roadmap UI](../roadmap.md)
- [Filosofia UI](../filosofia-modulo-ui.md)
