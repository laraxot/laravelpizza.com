# File Duplicati da Eliminare - Modulo Gdpr

## 🗑️ File da Eliminare (Case Sensitivity)

```bash
# Elimina file lowercase (duplicati)
rm Modules/Gdpr/tests/Feature/conflictresolutiontest.php
```

## ✅ File da Mantenere

```bash
# Mantieni file UpperCamelCase (corretto PSR-4)
Modules/Gdpr/tests/Feature/ConflictResolutionTest.php
```

## 📜 Regola

**File PHP con classi DEVONO usare UpperCamelCase (PascalCase) identico al nome della classe (PSR-4).**

Vedi documentazione completa: [Xot/docs/file-naming-case-sensitivity.md](../../Xot/docs/file-naming-case-sensitivity.md)

## ⚠️ Problema

Su Linux (production): due file diversi
Su Windows/macOS (dev): stesso file → **conflitti Git**

## 🔧 Comando Cleanup

### Manuale
```bash
cd laravel
rm Modules/Gdpr/tests/Feature/conflictresolutiontest.php
git add -A
git commit -m "fix: remove lowercase duplicate test file (PSR-4 compliance)"
```

### Automatico (Tutti i Moduli)
```bash
# Script automatico (include anche altri moduli)
bashscripts/fix/cleanup-case-duplicates.sh
```

---

**Riferimenti**:
- [Xot File Naming Rules](../../Xot/docs/file-naming-case-sensitivity.md)
- [Bashscripts Location Policy](../../Xot/docs/bashscripts-location-policy.md)
