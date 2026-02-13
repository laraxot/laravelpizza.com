# 🌍 **Geo Module** - Advanced Geographic Intelligence

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Geocoding](https://img.shields.io/badge/API-Google%20%7C%20Mapbox%20%7C%20Here-orange.svg)](https://developers.google.com/maps)

> **🚀 Modulo Geo**: Il motore di intelligenza geografica per Laraxot. Gestisce indirizzi completi, geocoding automatizzato tramite multi-provider e integra il database completo dei comuni italiani (ANPR) tramite modelli Sushi e JSON.

## 📋 **Panoramica**

Il modulo **Geo** risolve la complessità della gestione degli indirizzi e della navigazione spaziale.

- 🏠 **Address Sovereignty**: Modello `Address` centralizzato con normalizzazione dei componenti (via, civico, cap, locality).
- 🇮🇹 **Italian ANPR Support**: Database integrato di oltre 8.000 comuni italiani costantemente aggiornati.
- 🌍 **Hybrid Geocoding**: Integrazione flessibile con Google Maps, Mapbox, TomTom e Here.com.
- 🎯 **Spatial Queries**: Supporto per query radiali ("trova nelle vicinanze") e integrazione MySQL Spatial.
- 🎨 **Map Widgets**: Componenti Filament pronti all'uso per visualizzare e selezionare punti sulla mappa.

## ⚡ **Funzionalità Core**

### 🧩 **Hierarchical Models**
Struttura completa: `Region` -> `Province` -> `Comune` -> `Cap` -> `Address`. Ogni livello è ottimizzato per ricerca e performance.

### 🧘 **Philosophical Design**
"L'indirizzo è la proiezione fisica del record". Ogni entità nel sistema può acquisire proprietà geografiche tramite il trait `HasAddress`.

## 🚀 **Quick Start**

### 📦 **Popolamento Sushi (In-Memory)**
```bash
php artisan geo:sushi
```

### ⚙️ **Geocoding via Action**
```php
$address = app(GeocodeAddressAction::class)->execute('Piazza Duomo, Milano');
echo $address->latitude . ', ' . $address->longitude;
```

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa completa del modulo.
- 🙏 **[Filosofia Geografica](./philosophy.md)** - Come pensiamo lo spazio digitale.
- 🗺️ **[ROADMAP.md](./ROADMAP.md)** - Obiettivi verso l'integrazione PostGIS.
- 🇮🇹 **[Italian Comuni](./comune-sushi-analysis.md)** - Dettagli sull'integrazione ANPR.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 2.3.0
**✅ PHPStan level 10**: Compliance nativa garantita
