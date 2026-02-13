# Architettura Separazione Tema - Laravel Pizza Meetup

**Stato**: Documentazione fondamentale per il progetto

---

## 🏗️ **Introduzione**

Il progetto Laravel Pizza Meetup implementa un'architettura di tema separato che è fondamentale per il suo funzionamento. Questa architettura permette di mantenere il codice modulare e riutilizzabile.

---

## 📁 **Struttura della Separazione**

### **Configurazione Principale**
```
laravel/
├── config/
│   └── local/
│       └── laravelpizza/
│           └── xra.php                    # Configurazione tema
├── Modules/                              # Moduli principali
│   ├── Meetup/                           # Modulo principale
│   ├── User/                             # Autenticazione
│   └── ...
└── Themes/                               # Temi frontend
    └── Meetup/                           # Tema corrente
        ├── resources/
        │   ├── views/                    # Viste Blade
        │   ├── css/                      # Stili
        │   ├── js/                       # Script
        │   └── components/               # Componenti
        └── public/                       # Asset pubblicati
            └── assets/
                └── app-*.css
                └── app-*.js
```

### **File di Configurazione Chiave**

#### **laravel/config/local/laravelpizza/xra.php**
```php
<?php
return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'Meetup',
    'primary_lang' => 'it',
    'pub_theme' => 'Meetup',                    // ← Tema corrente
    'search_action' => 'it/videos',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => false,
    'register_adm_theme' => false,
    'register_pub_theme' => true,
];
```

#### **laravel/.env**
```env
APP_URL=http://laravelpizza.local
```

---

## 🔧 **Workflow di Sviluppo per il Tema**

### **1. Prerequisiti**
```bash
# Entrare nella cartella tema
cd laravel/Themes/Meetup/

# Aggiornare dipendenze PHP
composer update -W

# Installare dipendenze Node.js
npm install
```

### **2. Sviluppo Frontend**
```bash
# Compilare CSS/JS con Vite
npm run build

# Copiare asset in public_html
npm run copy
```

### **3. Verifica nel Browser**
- URL: `http://127.0.0.1:8000/it`
- Hard refresh: `Ctrl+Shift+R` (Windows/Linux) o `Cmd+Shift+R` (Mac)

---

## 🎯 **Regole Fondamentali per il Tema**

### **❌ Vietato**
- **MAI** creare file `.md` fuori dalle cartelle `docs/`
- **MAI** usare caratteri maiuscoli nei nomi file (tranne README.md)
- **MAI** ignorare il workflow npm build/copy
- **MAI** modificare codice senza PHPStan L10

### **✅ Obbligatorio**
- **SEMPRE** usare `laravel/Themes/Meetup/docs/` per documentazione
- **SEMPRE** eseguire `npm run build` dopo modifiche CSS/JS
- **SEMPRE** eseguire `npm run copy` per pubblicare asset
- **SEMPRE** verificare con PHPStan livello 10
- **SEMPRE** seguire pattern DRY + KISS

---

## 📊 **Workflow Completo**

```
Modifica File → PHPStan L10 → npm run build → npm run copy → Test Browser
     ↓           ↓              ↓              ↓              ↓
   Codice      Qualità        Compilazione    Pubblicazione    Visibilità
   Corretto    ✅             ✅             ✅             ✅
```

---

## 🚨 **Errori Comuni da Evitare**

### **Errore 1: Modifiche CSS/JS non visibili**
```bash
# ❌ SBAGLIATO
Modifico resources/css/app.css
Vado su http://127.0.0.1:8000/it
Le modifiche non sono visibili

# ✅ CORRETTO
cd laravel/Themes/Meetup/
npm run build
npm run copy
Vado su http://127.0.0.1:8000/it
Le modifiche sono visibili
```

### **Errore 2: Ignorare il workflow**
```bash
# ❌ SBAGLIATO
composer install
npm install
Vado direttamente a testare

# ✅ CORRETTO
composer update -W
npm install
npm run build
npm run copy
```

---

## 🎨 **Pattern Architetturali**

### **Componenti Blade Anonimi**
```blade
<!-- ✅ CORRETTO -->
<x-layouts.app>
    {{ $slot }}
</x-layouts.app>

<!-- ❌ ERRATO -->
<x-pub_theme::components.layouts.main>
    {{ $slot }}
</x-pub_theme::components.layouts.main>
```

### **Folio + Volt Pattern**
```
Request → Folio → Blade Page → Volt Component → Action → Service/Model
```

---

## 🔍 **Debugging**

### **Verifica Asset**
```bash
# Controlla se gli asset sono stati copiati
ls -la laravel/Themes/Meetup/public/assets/

# Verifica se Vite ha compilato
ls -la laravel/Themes/Meetup/resources/css/
ls -la laravel/Themes/Meetup/resources/js/
```

### **Verifica Configurazione**
```bash
# Controlla tema corrente
php artisan tinker
>>> config('local.laravelpizza.pub_theme')
=> "Meetup"
```

---

## 📚 **Documentazione Correlata**

- [development-workflow-css-js-changes.md](./development-workflow-css-js-changes.md)
- [folio-volt-json-system-complete.md](./folio-volt-json-system-complete.md)
- [laravelpizza-com-conversion-architecture.md](./laravelpizza-com-conversion-architecture.md)

---

## 🎯 **Conclusione**

La separazione del tema è **fondamentale** per il funzionamento del progetto Laravel Pizza Meetup. Seguire rigorosamente il workflow assicura:
- ✅ **Qualità del codice** con PHPStan L10
- ✅ **Asset correttamente compilati** con Vite
- ✅ **Visibilità immediata** delle modifiche
- ✅ **Mantenibilità** a lungo termine

**Questa regola è ASSOLUTAMENTE OBBLIGATORIA per tutti i sviluppatori del progetto!**

---

**Documentazione**: `laravel/Themes/Meetup/docs/02-architecture/01-theme-separation-architecture.md`  
**Ultimo Aggiornamento**: 2026-02-02