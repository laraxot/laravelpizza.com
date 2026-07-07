# 🌐 FixCity Local VHost Configuration

> **Last Updated**: 2026-03-31
> **Status**: ✅ Installato e Attivo
> **Environment**: Local Development (WSL2)
> **Server**: Apache 2.4.64 (Ubuntu)

---

## 🎯 Overview

This document describes the Apache VirtualHost configuration for local development of the FixCity platform using the domain `fixcity.local`.

### Key Points

- **Domain**: `fixcity.local`
- **Document Root**: `/var/www/_bases/base_fixcity_fila5/public_html`
- **Config sorgente**: `laravel/config/vhost/fixcity.local.conf`
- **Config Apache**: `/etc/apache2/sites-available/fixcity.local.conf` ✅ abilitato
- **Hosts (Windows)**: `172.27.106.41 fixcity.local` in `C:\Windows\System32\drivers\etc\hosts`
- **Port**: 80 (HTTP)

---

## 📁 File Locations

```
/var/www/_bases/base_fixcity_fila5/
├── laravel/
│   └── config/
│       └── vhost/
│           └── fixcity.local.conf    # Apache vhost configuration
└── public_html/                      # Document root (web accessible)
    └── index.php                     # Laravel entry point
```

---

## 🚀 Quick Start

### 1. Enable the VirtualHost

```bash
# Copy configuration to Apache sites-available
sudo cp /var/www/_bases/base_fixcity_fila5/laravel/config/vhost/fixcity.local.conf /etc/apache2/sites-available/fixcity.local.conf

# Enable the site
sudo a2ensite fixcity.local

# Reload Apache
sudo systemctl reload apache2
```

> **Stato attuale**: ✅ Già installato e attivo (2026-03-31)

### 2. Hosts File (WSL2)

In ambiente WSL2 il file `/etc/hosts` è auto-generato. Aggiungere l'entry nel file Windows:

`C:\Windows\System32\drivers\etc\hosts`

```
172.27.106.41 fixcity.local
```

> **Stato attuale**: ✅ Già presente nel file hosts Windows

### 3. Verify Configuration

```bash
# Test Apache configuration
sudo apache2ctl configtest

# Check if vhost is enabled
apache2ctl -S | grep fixcity
```

### 4. Access the Application

Open your browser and navigate to:
- `http://fixcity.local`
- `http://www.fixcity.local`

---

## ⚙️ Configuration Details

### VirtualHost Structure

```apache
<VirtualHost *:80>
    # Server Configuration
    ServerName fixcity.local
    ServerAlias www.fixcity.local
    
    # Document Root - MUST point to public_html
    DocumentRoot /var/www/_bases/base_fixcity_fila5/public_html
    
    # Directory Permissions
    <Directory /var/www/_bases/base_fixcity_fila5>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    <Directory /var/www/_bases/base_fixcity_fila5/public_html>
        Options -Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
        
        # Laravel .htaccess rules
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php [L]
        </IfModule>
    </Directory>
    
    # Logging Configuration
    ErrorLog ${APACHE_LOG_DIR}/fixcity_local_error.log
    CustomLog ${APACHE_LOG_DIR}/fixcity_local_access.log combined
</VirtualHost>
```

### Key Directives

| Directive | Purpose | Value |
|-----------|---------|-------|
| `ServerName` | Primary domain | `fixcity.local` |
| `ServerAlias` | Additional domains | `www.fixcity.local` |
| `DocumentRoot` | Web root directory | `public_html/` |
| `AllowOverride All` | Enable .htaccess | Required for Laravel |
| `mod_rewrite` | URL rewriting | Laravel routing |

---

## 🔧 Troubleshooting

### Issue: Site Not Loading

**Check Apache Error Log:**
```bash
sudo tail -f /var/log/apache2/fixcity_local_error.log
```

**Verify Permissions:**
```bash
sudo chown -R www-data:www-data /var/www/_bases/base_fixcity_fila5/public_html
sudo chmod -R 755 /var/www/_bases/base_fixcity_fila5/public_html
```

### Issue: 403 Forbidden

**Solution:**
```bash
# Check directory permissions
ls -la /var/www/_bases/base_fixcity_fila5/public_html

# Fix permissions if needed
sudo chmod -R 755 /var/www/_bases/base_fixcity_fila5
```

### Issue: 500 Internal Server Error

**Check Laravel Logs:**
```bash
tail -f /var/www/_bases/base_fixcity_fila5/laravel/storage/logs/laravel.log
```

**Verify .env Configuration:**
```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
cat .env | grep APP_URL
# Should be: APP_URL=http://fixcity.local
```

### Issue: mod_rewrite Not Working

**Enable mod_rewrite:**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## 📋 Prerequisites

### Apache Modules Required

```bash
# Enable required modules
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo systemctl restart apache2
```

### PHP Requirements

- PHP 8.1+
- PHP extensions:
  - `php-mysql` or `php-sqlite`
  - `php-mbstring`
  - `php-xml`
  - `php-curl`
  - `php-zip`
  - `php-gd`

---

## 🔒 Security Considerations

### Development Environment

⚠️ **WARNING**: This configuration is for **LOCAL DEVELOPMENT ONLY**.

For production environments:
1. Use HTTPS (SSL/TLS)
2. Disable directory indexing
3. Add security headers
4. Restrict access by IP
5. Use environment-specific configurations

### Security Headers (Optional for Development)

```apache
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

---

## 📊 Architecture

### Request Flow

```
Browser Request
    ↓
Apache VirtualHost (fixcity.local:80)
    ↓
DocumentRoot (public_html/)
    ↓
.htaccess (URL Rewriting)
    ↓
index.php (Laravel Entry Point)
    ↓
Laravel Application (laravel/)
    ↓
Response
```

### Directory Structure

```
base_fixcity_fila5/
├── public_html/              ← Document Root (web accessible)
│   ├── index.php            ← Entry point
│   ├── .htaccess            ← URL rewriting rules
│   ├── robots.txt
│   └── favicon.ico
├── laravel/                  ← Application code (NOT web accessible)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── Modules/
│   ├── Themes/
│   └── vendor/
└── docs/
    └── project/
        └── vhost-configuration.md  ← This file
```

---

## 🔄 Related Configurations

### Alternative: Nginx

For Nginx users, see: `docs/project/vhost-nginx-configuration.md`

### Alternative: PHP Built-in Server

For quick testing:
```bash
cd /var/www/_bases/base_fixcity_fila5/public_html
php -S localhost:8000
```

### Docker Development

For Docker-based development, see: `docker/docker-compose.yml`

---

## 📝 Maintenance

### Update VHost Configuration

1. Edit `laravel/config/vhost/fixcity.local.conf`
2. Copy to Apache: `sudo cp laravel/config/vhost/fixcity.local.conf /etc/apache2/sites-available/`
3. Reload Apache: `sudo systemctl reload apache2`

### Backup Configuration

```bash
# Backup current vhost
sudo cp /etc/apache2/sites-available/fixcity.local.conf \
        /etc/apache2/sites-available/fixcity.local.conf.backup.$(date +%Y%m%d)
```

---

## 🧪 Testing

### Verify VirtualHost

```bash
# List all virtual hosts
apache2ctl -S

# Test configuration syntax
apache2ctl configtest

# Check if site is enabled
ls -la /etc/apache2/sites-enabled/ | grep fixcity
```

### Test Domain Resolution

```bash
# Check hosts file entry
ping fixcity.local
# Should resolve to 127.0.0.1

# Or use getent
getent hosts fixcity.local
```

### Test Application

```bash
# Test with curl
curl -I http://fixcity.local

# Should return HTTP/1.1 200 OK
```

---

## 🔗 References

### Internal Documentation

- [Deployment Guide](deployment-guide.md)
- [Environment Configuration](environment-setup.md)
- [Apache Configuration Best Practices](apache-best-practices.md)

### External Resources

- [Apache VirtualHost Documentation](https://httpd.apache.org/docs/2.4/vhosts/)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Apache mod_rewrite](https://httpd.apache.org/docs/current/mod/mod_rewrite.html)

---

## 📞 Support

### Getting Help

- **Slack**: #devops channel
- **GitHub**: Create issue with label `infrastructure`
- **Documentation**: Check `docs/project/` for related guides

### Common Issues

| Issue | Solution |
|-------|----------|
| 403 Forbidden | Check directory permissions |
| 500 Error | Check Laravel logs |
| Site not loading | Verify hosts file entry |
| mod_rewrite not working | Enable mod_rewrite module |

---

**Maintainer**: DevOps Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Production Ready (for local development)
