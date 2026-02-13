# 🌐 **Lang Module** - Eccellenza nella Localizzazione

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)

> **🚀 Modulo Lang**: Il motore di localizzazione avanzata per l'ecosistema Laraxot. Gestisce traduzioni automatiche, modelli traducibili e standardizzazione dei contenuti multilingua.

## 📋 **Panoramica**

Il modulo **Lang** centralizza tutta la logica di internazionalizzazione dell'applicazione, estendendo le funzionalità native di Laravel per supportare:

- 🏗️ **Translatable Models**: Integrazione con Spatie e Astrotomic per modelli multilingua.
- 🔄 **Automatic Translation**: Sistema di chiavi intelligenti che riduce il boilerplate.
- 🗺️ **Advanced Routing**: Localizzazione degli URL via `mcamara/laravel-localization`.
- 🛠️ **Artisan Tools**: Comandi per validare, sincronizzare e correggere i file di traduzione.
- 🎯 **Super Mucca Rules**: Rigida separazione tra logica e contenuto.

## ⚡ **Funzionalità Core**

### 🧩 **Sincronizzazione Automatica**
Il modulo garantisce che ogni chiave aggiunta nel locale principale (IT) sia presente e sincronizzata nei locali secondari (EN, DE).

### 🏷️ **Naming Conventions**
Implementa regole ferree per le chiavi di traduzione:
- `lowercase`: Tutte le chiavi sono minuscole.
- `dot.notation`: Struttura gerarchica chiara.
- `semantic`: Le chiavi descrivono il contenuto, non la posizione.

## 🚀 **Quick Start**

### 📦 **Installazione**
```bash
# Abilitare il modulo
php artisan module:enable Lang

# Validare le traduzioni attuali
php artisan lang:validate
```

### ⚙️ **Configurazione**
Consulta [config/lang.php](../config/lang.php) per gestire i locali supportati e le strategie di fallback.

## 📚 **Documentazione Completa**

- 📖 **[Indice Documentazione](./index.md)** - Punto di ingresso per tutti i temi.
- 🗺️ **[Roadmap](./roadmap.md)** - Stato attuale e obiettivi futuri.
- 🧠 **[Filosofia](./filosofia-modulo-lang.md)** - I principi "Zen" della localizzazione.
- 🛠️ **[Best Practices](./best-practices.md)** - Come scrivere traduzioni perfette.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 2.1.0
**🐛 PHPStan level 10**: In fase di completamento ✅
https://github.com/dimsav/laravel-translatable

https://github.com/Astrotomic/laravel-translatable !!

https://github.com/spatie/laravel-translatable

https://blog.quickadminpanel.com/10-best-laravel-packages-for-multi-language-translations/

## Collegamenti tra versioni di readme.md
* [readme.md](../../../Gdpr/docs/readme.md)
* [readme.md](../../../UI/docs/readme.md)
* [readme.md](../../../Lang/docs/readme.md)
* [readme.md](../../../Activity/docs/readme.md)
* [readme.md](../../../Cms/docs/readme.md)

## Extra risorse da _docs

(Nessun nuovo link da aggiungere: i link di _docs/readme.txt sono già presenti in questo file)
