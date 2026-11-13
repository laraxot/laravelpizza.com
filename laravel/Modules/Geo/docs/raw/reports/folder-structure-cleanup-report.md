# Module Folder Structure Cleanup Report

> **Report: Pulizia e Documentazione Struttura Cartelle Moduli**
> 
> **Data:** 2026-03-13
> **Status:** In Progress
> **Completion:** 10% (1/10 violazioni stimate)

---

## Problema Identificato

È stata rilevata la presenza di cartelle di classi PHP nella root di alcuni moduli, invece che sotto la cartella `app/` come previsto dalla convenzione Laravel.

### Esempio del Problema

```
❌ laravel/Modules/Gdpr/Enums/ConsentType.php  (SBAGLIATO - duplicato)
✅ laravel/Modules/Gdpr/app/Enums/ConsentType.php (CORRETTO)
```

---

## Regola Generale

**Tutte le classi PHP devono essere sotto `app/`:**

```
laravel/Modules/{ModuleName}/
├── app/                      ✅ CORRETTO
│   ├── Enums/               ✅ Enumerazioni
│   ├── Models/              ✅ Modelli Eloquent
│   ├── Actions/             ✅ Azioni
│   ├── Controllers/         ✅ Controller
│   ├── Filament/            ✅ Componenti Filament
│   ├── Traits/              ✅ Traits
│   └── Providers/           ✅ Service Providers
├── config/                  ✅ Configurazioni
├── database/                ✅ Database
├── docs/                    ✅ Documentazione
└── ...
```

### Eccezione: Xot Module (Core Framework)

Solo Xot può avere cartelle speciali nella root:

```
laravel/Modules/Xot/
├── helpers/                 ✅ ECCEZIONE XOT - Helper functions
├── Datas/                   ✅ ECCEZIONE XOT - Data transfer objects
├── Services/                ✅ ECCEZIONE XOT - Shared services
├── Filament/                ✅ ECCEZIONE XOT - Filament components
├── packages/                ✅ ECCEZIONE XOT - Package stubs
├── stubs/                   ✅ ECCEZIONE XOT - Code generation
├── app/                     ✅ Standard Laravel app folder
└── ...
```

**Perché:**
- Xot è il modulo core framework
- Queste cartelle contengono risorse condivise
- Non sono classi autoloadate via PSR-4

---

## Azioni Correttive Completate

### 1. Rimozione Cartelle Duplicate ✅

| Modulo | Cartella Rimossa | Contenuto | Status |
|--------|------------------|-----------|--------|
| Gdpr | `Enums/` | `ConsentType.php` (duplicato) | ✅ Rimosso |

**Nota:** Il file in `app/Enums/` è migliore (più recente, `strict: true`, codice più pulito).

### 2. Documentazione Creata ✅

| Documento | Path | Status |
|-----------|------|--------|
| Module Folder Structure | `docs/conventions/module-folder-structure.md` | ✅ Creato |
| Cleanup Report | `docs/reports/folder-structure-cleanup-report.md` | ✅ Creato |

### 3. Aggiornamento Regole ✅

| File | Aggiornamento | Status |
|------|---------------|--------|
| `AGENTS.md` | Aggiunta sezione Module Folder Structure | ✅ Completato |
| Memory (Global) | Folder structure convention rule | ✅ Salvato |

### 4. GitHub Integration ✅

| Resource | Status | Link |
|----------|--------|------|
| GitHub Issue | ✅ Creata | [#107](https://github.com/provtv/base_ptv_fila5_mono/issues/107) |

---

## Analisi Dettagliata: Gdpr Module

### Prima del Cleanup

```
laravel/Modules/Gdpr/
├── Enums/                    ❌ SBAGLIATO
│   └── ConsentType.php      ❌ Duplicato (vecchio)
├── app/
│   └── Enums/
│       └── ConsentType.php  ✅ CORRETTO (nuovo, migliore)
└── ...
```

### Dopo il Cleanup

```
laravel/Modules/Gdpr/
├── app/
│   └── Enums/
│       └── ConsentType.php  ✅ CORRETTO (unico)
└── ...
```

### Confronto File

| Caratteristica | Root Enums/ | app/Enums/ | Vincitore |
|----------------|-------------|------------|-----------|
| `strict_types` | ✅ Yes | ✅ Yes | Pareggio |
| `strict: true` | ❌ No | ✅ Yes | app/Enums/ |
| Commented code | ✅ Yes | ❌ No (clean) | app/Enums/ |
| Traits | ✅ Yes | ✅ Yes | Pareggio |
| Methods | ✅ Basic | ✅ Enhanced | app/Enums/ |

**Decisione:** Mantenere `app/Enums/ConsentType.php` (migliore qualità)

---

## Violazioni Potenziali da Verificare

### Moduli da Auditare (41 rimanenti)

| Modulo | Violazioni Potenziali | Priority | Status |
|--------|----------------------|----------|--------|
| Activity | Nessuna evidente | Medium | ⏳ Da verificare |
| Badge | Nessuna evidente | Medium | ⏳ |
| CertFisc | Nessuna evidente | Medium | ⏳ |
| ContoAnnuale | Nessuna evidente | Medium | ⏳ |
| DbForge | Nessuna evidente | Medium | ⏳ |
| Europa | Nessuna evidente | Medium | ⏳ |
| Gdpr | ✅ Enums risolta | High | ✅ Completato |
| Inail | Nessuna evidente | Medium | ⏳ |
| Incentivi | Nessuna evidente | Medium | ⏳ |
| IndennitaCondizioniLavoro | Nessuna evidente | Medium | ⏳ |
| IndennitaResponsabilita | Nessuna evidente | Medium | ⏳ |
| Job | Nessuna evidente | Medium | ⏳ |
| Lang | Nessuna evidente | Medium | ⏳ |
| Legge104 | Nessuna evidente | Medium | ⏳ |
| Legge109 | Nessuna evidente | Medium | ⏳ |
| Media | Nessuna evidente | Medium | ⏳ |
| Mensa | Nessuna evidente | Medium | ⏳ |
| MobilitaVolontaria | Nessuna evidente | Medium | ⏳ |
| Notify | Nessuna evidente | Medium | ⏳ |
| Pdnd | Nessuna evidente | Medium | ⏳ |
| Performance | Nessuna evidente | Medium | ⏳ |
| Prenotazioni | Nessuna evidente | Medium | ⏳ |
| PresenzeAssenze | Nessuna evidente | Medium | ⏳ |
| Progressioni | Nessuna evidente | Medium | ⏳ |
| Ptv | Nessuna evidente | Medium | ⏳ |
| Questionari | Nessuna evidente | Medium | ⏳ |
| Rating | Nessuna evidente | Medium | ⏳ |
| Seo | Nessuna evidente | Medium | ⏳ |
| Setting | Nessuna evidente | Medium | ⏳ |
| Sigma | Nessuna evidente | Medium | ⏳ |
| Sindacati | Nessuna evidente | Medium | ⏳ |
| Tenant | Nessuna evidente | Medium | ⏳ |
| UI | Nessuna evidente | Medium | ⏳ |
| User | Nessuna evidente | Medium | ⏳ |
| Xot | ✅ Eccezione valida | N/A | ✅ Verificato |

### Themes

| Theme | Violazioni Potenziali | Priority | Status |
|-------|----------------------|----------|--------|
| One | Nessuna evidente | Medium | ⏳ |
| Zero | Nessuna evidente | Medium | ⏳ |

---

## Script di Verifica (Da Implementare)

```bash
#!/bin/bash
# verify-module-folders.sh

echo "Checking for folder structure violations..."

for dir in laravel/Modules/*/; do
    module_name=$(basename "$dir")
    
    # Skip Xot (has special folders)
    if [ "$module_name" = "Xot" ]; then
        continue
    fi
    
    # Check for common violations
    for folder in Enums Models Actions Controllers Traits; do
        if [ -d "$dir$folder" ]; then
            echo "❌ VIOLATION: $dir$folder (should be in app/$folder)"
        fi
    done
done

echo "Check complete!"
```

---

## Prossimi Passi

### Immediati (Q2 2026)

- [ ] Audit completo di tutti i 42 moduli
- [ ] Rimuovere eventuali altre violazioni
- [ ] Verificare che non ci siano duplicati
- [ ] Aggiornare documentazione moduli

### Medio Termine (Q3 2026)

- [ ] Aggiungere script di verifica automatica
- [ ] Integrare controllo nei CI/CD
- [ ] Aggiungere pre-commit hook
- [ ] Creare migration guide per moduli esistenti

### Lungo Termine (Q4 2026)

- [ ] Audit trimestrale struttura cartelle
- [ ] Automazione completa verifica
- [ ] Documentazione aggiornata per ogni modulo

---

## Riferimenti

### Documentazione

- [Module Folder Structure](conventions/module-folder-structure.md)
- [Workspace Naming Convention](conventions/workspace-naming.md)
- [AGENTS.md](../../AGENTS.md)
- [Project Structure](../../docs/project/structure.md)

### GitHub

- Issue: [#107](https://github.com/provtv/base_ptv_fila5_mono/issues/107)
- Discussion: N/A (gh non supporta discussion command)

### Laravel

- [Laravel Folder Structure](https://laravel.com/docs/structure)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Laravel Packages](https://laravel.com/docs/packages)

---

## Metriche

| Metrica | Valore | Target | Status |
|---------|--------|--------|--------|
| Moduli Verificati | 1/42 | 42/42 | 🟡 2% |
| Violazioni Risolte | 1/10 (stima) | 10/10 | 🟡 10% |
| Documentazione | 100% | 100% | ✅ Complete |
| AGENTS.md Updated | ✅ | ✅ | ✅ Complete |
| Memory Updated | ✅ | ✅ | ✅ Complete |
| GitHub Issue | ✅ | ✅ | ✅ Complete |

---

## Contatti

- **Report Owner:** Development Team
- **Last Updated:** 2026-03-13
- **Next Review:** 2026-04-13

---

*Report generato automaticamente - Ultimo aggiornamento: 2026-03-13*
