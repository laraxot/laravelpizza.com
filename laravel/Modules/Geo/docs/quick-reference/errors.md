# 📋 Quick Reference - Errori Critici e Soluzioni

> **RIFERIMENTO RAPIDO** per sviluppatori PTVX - soluzioni immediate ai problemi più comuni.

## 🚨 Errori Critici (Non Fare MAI)

| ❌ ERRORE GRAVE | ✅ SOLUZIONE CORRETTA | 📖 Dove Leggere |
|----------------|----------------------|----------------|
| `property_exists($model, 'field')` | `isset($model->field)` | [Eloquent Properties](../claude/eloquent-properties.md) |
| `extends Resource` | `extends XotBaseResource` | [Architettura](../claude/architecture-rules.md#base-classes) |
| `->label('Nome')` | Traduzioni automatiche | [Documentazione](../claude/documentation-policy.md#labels) |
| Script in `laravel/` | Script in `../bashscripts/` | [Task Sviluppo](../claude/development-tasks.md#scripts) |
| Tag `<style>` in PDF | CSS inline only | [Html2Pdf Guide](../claude/html2pdf-guide.md) |

## 🐛 Errori Comuni per Framework

### Filament 4
```php
// ❌ SBAGLIATO
class MyResource extends Resource {
    // Errori multipli...
}

// ✅ CORRETTO
class MyResource extends XotBaseResource {
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            // Campi senza ->label()
            TextInput::make('nome'),
        ];
    }
}
```

### Eloquent/Models
```php
// ❌ SBAGLIATO
if (property_exists($user, 'email')) {
    // Problemi di performance e affidabilità
}

// ✅ CORRETTO
if ($user->email ?? null) {
    // Sicuro e performante
}
```

### PDF Generation
```php
// ❌ SBAGLIATO - Causano HtmlParsingException
<style>
    .header { font-size: 18pt; }
</style>

// ✅ CORRETTO - Solo CSS inline
<div style="font-size: 18pt;">Header</div>
```

## ⚡ Comandi Rapidi

### Qualità Codice
```bash
# PHPStan completo
cd laravel && ./vendor/bin/phpstan analyse --level=9

# Fix codice stile
./vendor/bin/php-cs-fixer fix

# Test suite
./vendor/bin/pest
```

### PDF Debug
```bash
# Validazione template PDF
find Modules/*/resources/views -name "*pdf*.blade.php" -exec tidy -q -e {} \;

# Test generazione PDF
php artisan tinker
>>> app(GetPdfContentByRecordAction::class)->execute(Model::first())
```

### Database
```bash
# Migrazioni
php artisan migrate

# Seed
php artisan db:seed

# Rollback (solo dev)
php artisan migrate:rollback
```

## 🗂️ Struttura File Corretta

```
PTVX/
├── laravel/           # Codice applicazione
│   ├── Modules/       # Moduli Laravel
│   └── Themes/        # Temi frontend
├── bashscripts/       # Script shell
├── docs/             # Documentazione
│   ├── claude/       # Guide Claude AI
│   └── modules.md    # Indice moduli
└── CLAUDE.md         # Questo file (legacy)
```

## 🔍 Debug Checklist

### Per Problema PDF
- [ ] Template ha tag `<style>`? → Rimuovi, usa CSS inline
- [ ] File Blade termina correttamente? → Verifica `</page>`
- [ ] Immagini esistono? → Converti in base64
- [ ] HTML valido? → `tidy -q -e template.blade.php`

### Per Errore PHPStan
- [ ] `declare(strict_types=1);` presente?
- [ ] Tipi di ritorno espliciti?
- [ ] Proprietà `@var` documentate?
- [ ] `mixed` usato solo quando necessario?

### Per Problema Database
- [ ] Migrazione ha `down()`? → Rimuovi (usa XotBaseMigration)
- [ ] Foreign key corretta? → `constrained()` invece di manuale
- [ ] Modello estende BaseModel? → Sì, del suo modulo

## 📞 Quando Chiedere Aiuto

### Prima di chiedere:
1. Leggi [Errori Comuni](../claude/common-pitfalls.md)
2. Cerca in [Troubleshooting](../troubleshooting/)
3. Verifica con [Quick Reference](../quick-reference/)

### Documentazione Collegata:
- **[Regole Fondamentali](../claude/core.md)** - Leggi per prime
- **[Architettura](../claude/architecture-rules.md)** - Come è strutturato
- **[Best Practices](../best-practices/)** - Guide approfondite

---

**💡 Ricorda**: La maggior parte dei problemi ha già una soluzione documentata!

*Ultimo aggiornamento: Dicembre 2025*
