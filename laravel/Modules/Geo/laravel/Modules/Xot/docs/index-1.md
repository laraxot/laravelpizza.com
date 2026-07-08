# 📚 Xot Module - Documentation Index

**Path**: `laravel/Modules/Xot/docs/`  
**Modulo**: @Modules/Xot

## 🎯 Scopo

**CUORE DEL FRAMEWORK LARAXOT**. Fornisce le classi base (XotBaseResource, XotBaseModel, XotBaseServiceProvider) e le convenzioni che abilitano tutti gli altri moduli del sistema.

> ⚠️ **OBBLIGATORIO**: Tutti i moduli Laraxot estendono le classi Xot, MAI quelle di Filament o Laravel direttamente.

## 📦 Struttura

```
docs/
├── 00-INDEX.md          # Questo indice
├── README.md            # Panoramica modulo
├── architecture/        # Architettura base
├── development/         # Sviluppo ed estensione
├── features/           # Funzionalità core
├── quality/            # Quality assurance
├── maintenance/         # Manutenzione
└── [categorie]/        # Altre documentazioni
```

## 📄 Documenti

### Architecture
| File | Scopo |
|------|-------|
| architecture/base-classes.md | Classi base |
| architecture/models.md | Modelli core |
| architecture/providers.md | Service providers |
| architecture/database.md | Database layer |

### Development
| File | Scopo |
|------|-------|
| development/setup.md | Setup e configurazione |
| development/extensions.md | Pattern di estensione |
| development/practices.md | Best practices |
| development/troubleshooting.md | Troubleshooting |

### Quality
| File | Scopo |
|------|-------|
| quality/phpstan.md | PHPStan compliance |
| quality/standards.md | Code standards |
| quality/testing.md | Testing strategies |
| quality/performance.md | Performance |

### Features
| File | Scopo |
|------|-------|
| features/filament.md | Integrazione Filament |
| features/auth.md | Autenticazione |
| features/authorization.md | Autorizzazione |
| features/localization.md | Localizzazione |

## 🔗 Riferimenti

- [AGENTS.md](../../../../AGENTS.md) - Project guidelines
- [Laraxot Main Docs](../../../docs/) - Documentazione generale

## 📊 Metriche Modulo

| Aspetto | Valore |
|---------|--------|
| Base Classes | 50+ |
| Service Providers | 20+ |
| Traits | 15+ |
| PHPStan Level | 10 |
| Test Coverage | 95% |

---

**Ultimo Aggiornamento**: 2026-03-24
