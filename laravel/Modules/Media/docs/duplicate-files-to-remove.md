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

Vedi documentazione completa: [Xot/docs/file-naming-case-sensitivity.md](../../Xot/docs/file-naming-case-sensitivity.md)

## 🔧 Comando Cleanup

### Manuale
```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel
rm Modules/Media/tests/Filament/Resources/mediaconvertresourcetest.php
git add -A
git commit -m "fix: remove lowercase duplicate test file (PSR-4 compliance)"
```

### Automatico (Tutti i Moduli)
```bash
# Script automatico (include anche altri moduli)
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/fix/cleanup-case-duplicates.sh
```

---

**Riferimenti**: 
- [Xot File Naming Rules](../../Xot/docs/file-naming-case-sensitivity.md)
- [Bashscripts Location Policy](../../Xot/docs/bashscripts-location-policy.md)

