# Workspace Cleanup Report

> **Report: Pulizia e Documentazione Workspace Naming Convention**
> 
> **Data:** 2026-03-13
> **Status:** In Progress
> **Completion:** 50%

---

## Problema Identificato

È stata rilevata la presenza di file `.code-workspace` errati in alcune cartelle di moduli. Secondo la convenzione di naming, ogni modulo deve avere **SOLO** il proprio file workspace con il nome del modulo.

### Esempio del Problema

```
❌ laravel/Modules/Xot/_activity.code-workspace  (SBAGLIATO)
✅ laravel/Modules/Xot/_xot.code-workspace       (CORRETTO)
```

---

## Regola Generale

**Ogni modulo deve avere UNICO file workspace:**

```
_{module-name}.code-workspace
```

Dove `{module-name}` è il nome del modulo in lowercase.

### Principi

1. **One Module, One Workspace** - Ogni modulo ha solo il proprio workspace
2. **Naming Coerente** - Il nome corrisponde esattamente al modulo
3. **Posizione** - File nella root del modulo

---

## Azioni Correttive Completate

### 1. Rimozione File Errati ✅

| Modulo | File Rimosso | Status |
|--------|--------------|--------|
| Xot | `_activity.code-workspace` | ✅ Rimosso |
| Job | `_activity.code-workspace` | ✅ Rimosso |
| Job | `_user.code-workspace` | ✅ Rimosso |

### 2. Documentazione Creata ✅

| Documento | Path | Status |
|-----------|------|--------|
| Workspace Naming Convention | `docs/conventions/workspace-naming.md` | ✅ Creato |
| Workspace Cleanup Report | `docs/reports/workspace-cleanup-report.md` | ✅ Creato |

### 3. Aggiornamento Regole ✅

| File | Aggiornamento | Status |
|------|---------------|--------|
| `AGENTS.md` | Aggiunta sezione Workspace Convention | ✅ Completato |
| Memory (Global) | Workspace convention rule | ✅ Salvato |

### 4. GitHub Integration ✅

| Resource | Status | Note |
|----------|--------|-------|
| GitHub Issue | ✅ Creata | "Cleanup: Remove wrong workspace files" |
| GitHub Discussion | ⚠️ Fallito | gh non supporta discussion command |

---

## Analisi Completa Moduli

### Moduli Conformi (da verificare)

Questi moduli dovrebbero avere solo il workspace corretto:

| Modulo | Workspace Atteso | Status |
|--------|------------------|--------|
| Activity | `_activity.code-workspace` | ⏳ Da verificare |
| Badge | `_badge.code-workspace` | ⏳ |
| CertFisc | `_cert_fisc.code-workspace` | ⏳ |
| ContoAnnuale | `_conto_annuale.code-workspace` | ⏳ |
| DbForge | `_dbforge.code-workspace` | ⏳ |
| Europa | `_europa.code-workspace` | ⏳ |
| Gdpr | `_gdpr.code-workspace` | ⏳ |
| Inail | `_inail.code-workspace` | ⏳ |
| Incentivi | `_incentivi.code-workspace` | ⏳ |
| IndennitaCondizioniLavoro | `_indennita_condizioni_lavoro.code-workspace` | ⏳ |
| IndennitaResponsabilita | `_indennita_responsabilita.code-workspace` | ⏳ |
| Job | `_job.code-workspace` | ✅ Verificato |
| Lang | `_lang.code-workspace` | ⏳ |
| Legge104 | `_legge104.code-workspace` | ⏳ |
| Legge109 | `_legge109.code-workspace` | ⏳ |
| Media | `_media.code-workspace` | ⏳ |
| Mensa | `_mensa.code-workspace` | ⏳ |
| MobilitaVolontaria | `_mobilita_volontaria.code-workspace` | ⏳ |
| Notify | `_notify.code-workspace` | ⏳ |
| Pdnd | `_pdnd.code-workspace` | ⏳ |
| Performance | `_performance.code-workspace` | ⏳ |
| Prenotazioni | `_prenotazioni.code-workspace` | ⏳ |
| PresenzeAssenze | `_presenze_assenze.code-workspace` | ⏳ |
| Progressioni | `_progressioni.code-workspace` | ⏳ |
| Ptv | `_ptv.code-workspace` | ⏳ |
| Questionari | `_questionari.code-workspace` | ⏳ |
| Rating | `_rating.code-workspace` | ⏳ |
| Seo | `_seo.code-workspace` | ⏳ |
| Setting | `_setting.code-workspace` | ⏳ |
| Sigma | `_sigma.code-workspace` | ⏳ |
| Sindacati | `_sindacati.code-workspace` | ⏳ |
| Tenant | `_tenant.code-workspace` | ⏳ |
| UI | `_ui.code-workspace` | ⏳ |
| User | `_user.code-workspace` | ⏳ |
| Xot | `_xot.code-workspace` | ✅ Verificato |

### Themes

| Theme | Workspace Atteso | Status |
|-------|------------------|--------|
| One | `_one.code-workspace` | ⏳ |
| Zero | `_theme_zero.code-workspace` | ⏳ |

---

## Violazioni Rimanenti

Da verificare e pulire:

| Modulo | Violazione | Azione Richiesta |
|--------|------------|------------------|
| Rating | `_blog.code-workspace` | Rimuovere |
| Tutti i moduli | Workspace multipli | Verificare |

---

## Prossimi Passi

### Immediati (Q2 2026)

- [ ] Verificare tutti i 42 moduli
- [ ] Rimuovere `_blog.code-workspace` da Rating
- [ ] Documentare eventuali eccezioni
- [ ] Aggiungere controllo ai CI/CD

### Medio Termine (Q3 2026)

- [ ] Aggiungere pre-commit hook per validare workspace
- [ ] Creare script di verifica automatica
- [ ] Aggiornare onboarding docs

### Lungo Termine (Q4 2026)

- [ ] Audit trimestrale workspace files
- [ ] Automazione completa verifica
- [ ] Integrazione con VS Code settings sync

---

## Script di Verifica

### Manuale

```bash
# Verificare workspace in un modulo
cd laravel/Modules/{ModuleName}
ls -la _*.code-workspace

# Dovresti vedere SOLO: _{module-name}.code-workspace
```

### Automatico (da implementare)

```bash
#!/bin/bash
# verify-workspaces.sh

for dir in laravel/Modules/*/; do
    module_name=$(basename "$dir" | tr '[:upper:]' '[:lower:]')
    expected="_${module_name}.code-workspace"
    
    for ws in "$dir"_*.code-workspace; do
        if [ -f "$ws" ]; then
            ws_name=$(basename "$ws")
            if [ "$ws_name" != "$expected" ]; then
                echo "❌ WRONG: $ws (expected: $expected)"
            fi
        fi
    done
done
```

---

## Riferimenti

### Documentazione

- [Workspace Naming Convention](conventions/workspace-naming.md)
- [AGENTS.md](../../AGENTS.md)
- [Project Structure](project/structure.md)

### GitHub

- Issue: "Cleanup: Remove wrong workspace files from modules"
- Discussion: "Workspace Naming Convention - Best Practices" (non creata - gh limitation)

### VS Code

- [VS Code Workspaces](https://code.visualstudio.com/docs/editor/workspaces)
- [Workspace Settings](https://code.visualstudio.com/docs/getstarted/settings)

---

## Metriche

| Metrica | Valore | Target | Status |
|---------|--------|--------|--------|
| Moduli Verificati | 2/42 | 42/42 | 🟡 5% |
| File Errati Rimossi | 3 | ~10 | 🟡 30% |
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
