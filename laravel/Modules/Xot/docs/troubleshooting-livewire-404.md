# Troubleshooting: Livewire 404 Error

**Errore**: `404 Not Found` su `/livewire/update`

## 🔍 Problema

Browser mostra errori ripetuti:
```
Failed to load resource: the server responded with a status of 404 (Not Found)
:8000/livewire/update:1
```

## 🎯 Causa Radice

**APP_URL Mismatch**: L'applicazione è configurata per un dominio ma il browser accede tramite un altro.

### Scenario Tipico

```bash
# Configurazione .env
APP_URL=http://healthcare_app.local

# Browser accede a
http://127.0.0.1:8000
```

**Risultato**: Livewire genera URL con `healthcare_app.local` ma browser invia richieste a `127.0.0.1:8000` → 404

## ✅ Soluzioni

### Soluzione 1: Aggiornare APP_URL (Raccomandato)

Modificare `.env` per riflettere l'URL effettivo di accesso:

```bash
# Se accedi tramite 127.0.0.1:8000
APP_URL=http://127.0.0.1:8000

# Se accedi tramite localhost:8000
APP_URL=http://localhost:8000

# Se accedi tramite dominio locale
APP_URL=http://healthcare_app.local
```

**Dopo la modifica**:

```bash
php artisan config:clear
php artisan optimize:clear
```

### Soluzione 2: Aggiungere Host al Sistema

Se vuoi usare `healthcare_app.local`, aggiungi al file hosts:

**Linux/Mac**: `/etc/hosts`
```
127.0.0.1 healthcare_app.local
```

**Windows**: `C:\Windows\System32\drivers\etc\hosts`
```
127.0.0.1 healthcare_app.local
```

Poi accedi tramite: `http://healthcare_app.local:8000`

### Soluzione 3: Trusted Proxies (Per Ambienti Complessi)

Se usi proxy/load balancer, configura `TrustProxies`:

`app/Http/Middleware/TrustProxies.php`:

```php
protected $proxies = '*';

protected $headers = Request::HEADER_X_FORWARDED_FOR |
    Request::HEADER_X_FORWARDED_HOST |
    Request::HEADER_X_FORWARDED_PORT |
    Request::HEADER_X_FORWARDED_PROTO |
    Request::HEADER_X_FORWARDED_AWS_ELB;
```

## 🔍 Verifica Configurazione

```bash
# Verifica APP_URL attuale
php artisan tinker --execute="echo config('app.url');"

# Verifica route Livewire
php artisan route:list --name=livewire

# Test URL generato
php artisan tinker --execute="echo route('livewire.update');"
```

## 🎯 Checklist Diagnostica

- [ ] APP_URL corrisponde all'URL del browser?
- [ ] Cache configurazione pulita?
- [ ] Route Livewire esistono? (`php artisan route:list --name=livewire`)
- [ ] ServiceProvider Livewire registrato? (`php artisan about | grep -i livewire`)
- [ ] Browser non sta usando cache vecchia? (Hard refresh: Ctrl+F5)
- [ ] CSRF token presente nell'HTML? (Inspect `<meta name="csrf-token">`)

## 🐛 Altri Problemi Comuni

### DOMException: outerHTML

```
Uncaught DOMException: Failed to set the 'outerHTML' property on 'Element'
```

**Causa**: Conseguenza del 404 - Livewire non riesce ad aggiornare il DOM

**Soluzione**: Risolvere il 404, il DOMException sparirà

### Loop Infinito di Richieste

**Causa**: Livewire ritenta automaticamente richieste fallite

**Soluzione**: Risolvere il 404 di base, il loop si fermerà

## 📚 Pattern Corretto

### Sviluppo Locale

```bash
# .env per sviluppo locale con artisan serve
APP_URL=http://127.0.0.1:8000
```

### Sviluppo con Vhost

```bash
# .env per sviluppo con virtual host
APP_URL=http://healthcare_app.local
```

### Produzione

```bash
# .env per produzione
APP_URL=https://healthcare_app.com
```

## 🔧 Comandi Rapidi Fix

```bash
# Quick fix completo
cd laravel

# 1. Modifica APP_URL in .env
nano .env  # o vim .env

# 2. Pulisci cache
php artisan config:clear
php artisan optimize:clear

# 3. Verifica
php artisan tinker --execute="echo route('livewire.update');"

# 4. Hard refresh browser (Ctrl+F5)
```

## 📖 Riferimenti

- [Livewire Documentation](https://livewire.laravel.com/)
- [Laravel Configuration](https://laravel.com/docs/configuration)
- [Trusted Proxies](https://laravel.com/docs/requests#configuring-trusted-proxies)

---

**
**Modulo**: Xot
**Categoria**: Troubleshooting
