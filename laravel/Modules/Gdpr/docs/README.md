# 🛡️ **Gdpr Module** - Privacy, Compliance & Data Sovereignty

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Compliance](https://img.shields.io/badge/GDPR-Fully%20Compliant-blue.svg)](https://gdpr-info.eu/)

> **🚀 Modulo Gdpr**: L'armatura legale ed etica dell'applicazione. Fornisce un framework robusto per la gestione dei trattamenti dati, la registrazione dei consensi e la produzione di audit trail immutabili in conformità con il Regolamento (UE) 2016/679.

## 📋 **Panoramica**

Il modulo **Gdpr** integra la "Privacy by Design" nel cuore dell'architettura Laraxot.

- 📜 **Trattamenti Granulari**: Definizione di finalità, basi giuridiche e periodi di conservazione.
- 🗳️ **Consenso Esplicito**: Tracciamento UUID-based dei consensi prestati dagli utenti (o profili anonimi).
- 🕒 **Audit Immutabile**: Registrazione di ogni evento di privacy (accesso, rettifica, opposizione).
- 📄 **Compliance Reporting**: Export automatico di report PDF per dimostrare la conformità ai sensi dell'Art. 30 GDPR.
- 🍪 **Cookie Sovereignty**: Sistema di gestione cookie integrato con controllo dinamico degli script.

## ⚡ **Funzionalità Core**

### 🧩 **UUID-First Privacy**
Ogni record relativo alla privacy utilizza UUID per evitare l'esposizione di ID sequenziali e garantire l'anonimizzazione in fase di analisi.

### 🧘 **Philosophical Design**
Il dato appartiene all'individuo. Il sistema ne è solo il custode temporaneo per finalità specifiche e documentate.

## 🚀 **Quick Start**

### 📦 **Verifica Consenso**
```php
if ($user->hasGivenConsent('marketing')) {
    // Invia comunicazioni promozionali
}
```

### ⚙️ **Registrazione Evento Privacy**
```php
app(LogPrivacyEventAction::class)->execute($user, 'data_access', 'Visualizzazione cartella clinica');
```

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa di navigazione completa.
- 🙏 **[Filosofia Privacy](./philosophy.md)** - I comandamenti della sovranità digitale.
- 🗺️ **[Compliance Roadmap](./gdpr-compliance-roadmap.md)** - Evoluzione normativa del modulo.
- 🔬 **[Testing Guidelines](./testing.md)** - Come verifichiamo la tenuta legale dei log.

---

**🔄 
**📦 Versione**: 2.3.0
**✅ PHPStan level 10**: Compliance nativa garantita

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT