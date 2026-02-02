# 🌐 Tenant Module - Gestione Multi-Tenant Avanzata 🚀

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-orange.svg)](https://laravel.com)
[![Filament Version](https://img.shields.io/badge/Filament-5.x-purple.svg)](https://filamentphp.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

Il modulo **Tenant** fornisce una soluzione completa per il multi-tenancy in Laraxot, supportando sia database separati che isolamento dinamico dei dati.

## 📦 Caratteristiche Principali

- **Tenant Management**: Creazione e gestione profili tenant via Filament.
- **Isolamento Dinamico**: I dati sono isolati a livello di query e configurazione.
- **Dynamic Database Connections**: Le connessioni per ogni modulo sono generate a runtime da `TenantServiceProvider::registerDB()`.
- **Laravel 12 Support**: Piena integrazione con la filosofia di configurazione di Laravel 12.x.

## 🚀 Perché scegliere il modulo Tenant?

- **Efficienza**: Riduce al minimo la configurazione manuale dei database.
- **Scalabilità**: Progettato per gestire centinaia di tenant con una singola istanza.
- **Flessibilità**: Permette di definire database personalizzati per specifici moduli (es. `user`, `limesurvey`).

## 🔧 Installazione

```bash
# 1. Installa il modulo
composer require laraxot/tenant

# 2. Abilita il modulo
php artisan module:enable Tenant

# 3. Esegui le migrazioni
php artisan migrate
```

## 📚 Documentazione

Consulta la [documentazione completa](docs/README.md) per:
- [Standard Configurazione Database](docs/database-config-standard.md)
- [Architettura Multi-Tenant](docs/architecture.md)
- [Best Practices](docs/best-practices.md)

## 🤝 Contribuire

Siamo aperti a contribuzioni! Consulta le nostre [linee guida](.github/CONTRIBUTING.md).

## 📄 Licenza

Questo progetto è distribuito sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

---

**Author**: Marco Sottana - [@marco76tv](https://github.com/marco76tv)
