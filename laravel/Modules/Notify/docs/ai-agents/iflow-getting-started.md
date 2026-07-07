# IFLOW Getting Started

Come iniziare a lavorare sul progetto.

---

## 🚀 In 3 Passi

> Non serve essere "guru": serve voglia di imparare e rispetto per le regole del progetto.

---

### 1. Leggi le Regole Critiche

- `laravel/Modules/Xot/docs/critical-rules-consolidated.md`
- `laravel/Modules/Meetup/docs/rules-index.md`
- `laravel/Themes/Meetup/docs/critical-rules-consolidated.md`

---

### 2. Avvia l'Ambiente

Setup Laravel classico:

```bash
cd laravel
composer install
npm install
```

Dal tema Meetup:

```bash
cd Themes/Meetup
npm install
npm run build && npm run copy  # OBBLIGATORIO dopo ogni cambio CSS/JS
```

---

### 3. Visita il Frontoffice

- `http://127.0.0.1:8000/it`
- `http://127.0.0.1:8000/it/events`

Confronta con `https://laravelpizza.com` e trova le differenze da colmare.

---

## Workflow Critico

### Regole Fondamentali

- **MAI** creare file .md in posizioni sbagliate
- **MAI** usare maiuscole nei nomi .md (eccetto README.md e CHANGELOG.md)
- **SEMPRE** usare PHPStan Level 10 dopo aver modificato un file
- **SEMPRE** eseguire PHPMD e PHPInsights
- **MAI** usare `property_exists()` su modelli Eloquent
- **SEMPRE** verificare con `hasAttribute()` o type safety

---

## Struttura Progetto

- **Root**: `./`
- **Laravel app**: `laravel/`
- **Configurazione locale**: `laravel/config/local/laravelpizza/`
- **Tema corrente**: `laravel/Themes/Meetup/`

---

## 🔗 Link

- [Indice IFLOW](./iflow-split-index.md)
- [project-setup.md](./project-setup.md)
- [IFLOW.md originale](../../IFLOW.md)
- [Index principale](./index.md)
