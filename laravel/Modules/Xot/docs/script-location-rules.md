# Regole Posizione Script nel Progetto

## Regola Fondamentale

**OGNI** script utility, di analisi, di manutenzione o di qualsiasi altro tipo **DEVE** essere posizionato in:

```
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/
```

E **DEVE** essere categorizzato nella sottocartella appropriata.

## Motivazione Business

### Organizzazione e Manutenibilità
- **Centralizzazione**: Tutti gli script in una location prevedibile
- **Categorizzazione**: Facile reperimento per funzione
- **Documentazione**: Ogni script documentato in `bashscripts/docs/`
- **Versionamento**: Git tracking dedicato per utility

### Portabilità e Deployment
- **Path Relativi**: Script non dipendono da path assoluti
- **Isolamento**: Separazione netta tra applicazione Laravel e utility
- **Backup Selettivo**: Facile includere/escludere script dai backup
- **CI/CD**: Pipeline possono referenziare path standardizzati

### Clean Architecture
- **Root Pulita**: Root del progetto libera da script temporanei
- **Laravel Pulito**: Directory laravel/ contiene solo codice applicazione
- **Separazione Responsabilità**: Codice app ≠ Utility scripts

## Struttura Directory bashscripts/

```
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/
│
├── analysis/                    # Analisi di codice e moduli
│   ├── analyze_dependencies.sh
│   ├── find_unused_code.sh
│   └── module_statistics.sh
│
├── quality-assurance/           # Controlli di qualità
│   ├── phpstan_all_modules.sh  # ✅ Script creato
│   ├── run_phpstan.sh
│   ├── run_pint.sh
│   └── code_coverage.sh
│
├── git/                         # Gestione Git
│   ├── sync_subtree.sh
│   ├── clean_branches.sh
│   └── check_conflicts.sh
│
├── database/                    # Operazioni database
│   ├── backup_db.sh
│   ├── seed_all.sh
│   └── migrate_fresh.sh
│
├── maintenance/                 # Manutenzione sistema
│   ├── clear_caches.sh
│   ├── optimize_app.sh
│   └── cleanup_logs.sh
│
├── utilities/                   # Utility generali
│   ├── monitor_resources.sh
│   ├── generate_reports.sh
│   └── batch_operations.sh
│
├── testing/                     # Script di testing
│   ├── run_all_tests.sh
│   ├── test_coverage.sh
│   └── integration_tests.sh
│
├── fix/                         # Correzioni automatiche
│   ├── fix_namespaces.sh
│   ├── fix_permissions.sh
│   └── fix_formatting.sh
│
└── docs/                        # Documentazione script
    ├── phpstan-all-modules.md  # ✅ Documentazione creata
    ├── README.md
    └── [altri-script].md
```

## Esempi Pratici

### ✅ CORRETTO

```bash
# PHPStan analysis
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/quality-assurance/phpstan_all_modules.sh

# Module analysis
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/analysis/analyze_module.sh User

# Git sync
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/git/sync_all_subtrees.sh

# Database backup
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/database/backup_daily.sh
```

### ❌ ERRATO - Da Correggere Immediatamente

```bash
# ❌ Root del progetto
/var/www/_bases/base_ptvx_fila4_mono/analyze.sh
/var/www/_bases/base_ptvx_fila4_mono/script.sh

# ❌ Directory Laravel
/var/www/_bases/base_ptvx_fila4_mono/laravel/fix.sh
/var/www/_bases/base_ptvx_fila4_mono/laravel/test.php

# ❌ Dentro moduli
/var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/User/utility.sh
```

## Procedura Correzione Script Esistenti

Se trovi script in posizioni errate:

```bash
# 1. Identifica categoria appropriata
CATEGORIA="quality-assurance"  # o analysis, git, etc.

# 2. Sposta script
mv /percorso/errato/script.sh \
   /var/www/_bases/base_ptvx_fila4_mono/bashscripts/$CATEGORIA/script.sh

# 3. Aggiorna permessi
chmod +x /var/www/_bases/base_ptvx_fila4_mono/bashscripts/$CATEGORIA/script.sh

# 4. Crea documentazione
cat > /var/www/_bases/base_ptvx_fila4_mono/bashscripts/docs/script.md << 'EOF'
# Nome Script

## Posizione
`bashscripts/categoria/script.sh`

## Scopo
Descrizione breve

## Utilizzo
\`\`\`bash
bashscripts/categoria/script.sh [args]
\`\`\`

## Collegamenti
- [bashscripts README](../README.md)
EOF

# 5. Aggiorna riferimenti
grep -r "percorso/errato/script.sh" . --exclude-dir=.git
# Correggi tutti i riferimenti trovati
```

## Integrazione CI/CD

Gli script in `bashscripts/` possono essere facilmente integrati in pipeline CI/CD:

```yaml
# .gitlab-ci.yml o simili
quality_check:
  script:
    - bashscripts/quality-assurance/phpstan_all_modules.sh
    - bashscripts/quality-assurance/run_pint.sh
  
database_backup:
  script:
    - bashscripts/database/backup_daily.sh
```

## Checklist Sviluppatore

Prima di creare/modificare uno script:

- [ ] Ho verificato la categoria corretta?
- [ ] Lo script è in `bashscripts/categoria/`?
- [ ] Lo script è eseguibile? (`chmod +x`)
- [ ] Ho creato/aggiornato documentazione in `bashscripts/docs/`?
- [ ] Ho verificato che non ci siano script simili esistenti?
- [ ] Ho testato lo script?

## Enforcement

### Pre-commit Hook

Considera l'aggiunta di un pre-commit hook:

```bash
#!/bin/bash
# .git/hooks/pre-commit

# Verifica script nella root
if git diff --cached --name-only | grep -E '^[^/]+\.sh$'; then
  echo "❌ ERRORE: Script .sh trovati nella root del progetto!"
  echo "   Sposta in bashscripts/categoria/"
  exit 1
fi

# Verifica script in laravel/
if git diff --cached --name-only | grep -E '^laravel/[^/]+\.sh$'; then
  echo "❌ ERRORE: Script .sh trovati in laravel/!"
  echo "   Sposta in bashscripts/categoria/"
  exit 1
fi
```

## Casi Speciali

### Script Temporanei di Debug

Anche gli script temporanei devono seguire la regola:

```bash
# ✅ CORRETTO
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/utilities/temp_debug.sh

# ❌ ERRATO
/tmp/debug.sh  # Meglio evitare, preferire bashscripts/utilities/
```

### Script Generati Automaticamente

Gli script generati (es. da composer, artisan) nella directory laravel/vendor/ sono esclusi da questa regola.

## FAQ

### Q: Perché non posso mettere uno script nella root per comodità?
**A**: La "comodità" momentanea crea disorganizzazione permanente. Usa `bashscripts/utilities/` per script di uso frequente.

### Q: E se lo script è specifico di un modulo?
**A**: Anche script specifici di modulo vanno in `bashscripts/` categorizzati. Il nome dello script può indicare il modulo target.

### Q: Posso usare symlink dalla root a bashscripts/?
**A**: No. Usa alias bash o aggiungi `bashscripts/` al PATH se necessario.

## Collegamenti

- [bashscripts README](/var/www/_bases/base_ptvx_fila4_mono/bashscripts/README.md)
- [Laraxot Conventions](../../../docs/laraxot-conventions.md)
- [.cursor/rules/script-location-mandatory.mdc](../../../.cursor/rules/script-location-mandatory.mdc)

---

**Status**: REGOLA INVIOLABILE  
**Ultimo aggiornamento**: 2 Dicembre 2025  
**Applicabilità**: Tutti i membri del team, tutti i progetti Laraxot

⚠️ **ENFORCEMENT**: Violazioni devono essere corrette immediatamente in fase di code review.

