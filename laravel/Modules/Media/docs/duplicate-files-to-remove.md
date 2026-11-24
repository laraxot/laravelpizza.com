---
issues: []
discussions: []
title: "File Duplicati da Eliminare - Modulo Media"
module: "Media"
type: concept
tags: [duplicate, files, remove]
created: 2026-07-14
updated: 2026-07-14
qmd: "duplicate files to remove"
related:
  - "./webm.md"
---
# File Duplicati da Eliminare - Modulo Media

## 🗑️ File da Eliminare (Case Sensitivity)

```bash
# Elimina file lowercase (duplicato)
rm Modules/Media/tests/Filament/Resources/mediaconvertresourcetest.php
```

## ✅ File da Mantenere

```bash
# Mantieni file UpperCamelCase (corretto PSR-4)
Modules/Media/tests/Filament/Resources/MediaConvertResourceTest.php
```

## 📜 Regola

**File PHP con classi DEVONO usare UpperCamelCase (PascalCase) identico al nome della classe (PSR-4).**

Vedi documentazione completa: [Xot/docs/file-naming-case-sensitivity.md](../../xot/docs/file-naming-case-sensitivity.md)

## 🔧 Comando Cleanup

### Manuale
```bash
cd laravel
rm Modules/Media/tests/Filament/Resources/mediaconvertresourcetest.php
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
- [Xot File Naming Rules](../../xot/docs/file-naming-case-sensitivity.md)
- [Bashscripts Location Policy](../../xot/docs/bashscripts-location-policy.md)