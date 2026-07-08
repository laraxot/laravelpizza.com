# 🌐 VHost Governance Rules

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Active  
> **Enforcement**: Mandatory

---

## 📋 Overview

This document defines the **mandatory rules** for Apache VirtualHost configuration in the FixCity platform.

---

## 🎯 Core Principles

### 1. Document Root Rule

**Rule**: The document root MUST always be `public_html/`

```apache
# ✅ CORRECT
DocumentRoot /var/www/_bases/base_fixcity_fila5/public_html

# ❌ WRONG - Never point to laravel/ directly
DocumentRoot /var/www/_bases/base_fixcity_fila5/laravel
```

**Rationale**: 
- Security: Laravel application code is NOT web-accessible
- Standard: Follows Laravel deployment best practices
- Isolation: Public assets are separated from application logic

---

### 2. Configuration Location Rule

**Rule**: VHost configurations MUST be stored in `laravel/config/vhost/`

```
✅ CORRECT:
laravel/config/vhost/fixcity.local.conf

❌ WRONG:
- /etc/apache2/sites-available/fixcity.local.conf (not versioned)
- docs/vhost.conf (wrong location)
- config/fixcity.local.conf (wrong directory)
```

**Rationale**:
- Version Control: Configuration is tracked in Git
- Consistency: All configs in one location
- Portability: Easy to deploy across environments

---

### 3. Domain Naming Rule

**Rule**: Local development domains MUST use `.local` TLD

```apache
# ✅ CORRECT
ServerName fixcity.local
ServerAlias www.fixcity.local

# ❌ WRONG
ServerName fixcity.dev
ServerName fixcity.test
ServerName localhost/fixcity
```

**Rationale**:
- Standard: `.local` is reserved for local development
- Clarity: Clear distinction from production
- DNS: Avoids conflicts with real TLDs

---

### 4. Logging Rule

**Rule**: Each vhost MUST have dedicated log files

```apache
# ✅ CORRECT
ErrorLog ${APACHE_LOG_DIR}/fixcity_local_error.log
CustomLog ${APACHE_LOG_DIR}/fixcity_local_access.log combined

# ❌ WRONG - Don't use default Apache logs
# (No logging configuration)
```

**Rationale**:
- Debugging: Isolated logs per environment
- Performance: Easier log rotation
- Monitoring: Clear separation of concerns

---

### 5. Directory Permissions Rule

**Rule**: Directory permissions MUST follow least privilege principle

```apache
# ✅ CORRECT
<Directory /var/www/_bases/base_fixcity_fila5/public_html>
    Options -Indexes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
</Directory>

# ❌ WRONG - Too permissive
<Directory />
    Require all granted
</Directory>
```

**Key Directives**:
- `-Indexes`: Disable directory listing
- `+FollowSymLinks`: Allow symbolic links
- `+MultiViews`: Enable content negotiation
- `AllowOverride All`: Required for Laravel `.htaccess`

---

## 📁 File Structure Rules

### Configuration File Naming

**Pattern**: `{environment}.local.conf`

```
✅ CORRECT:
- fixcity.local.conf
- staging.local.conf

❌ WRONG:
- vhost.conf (too generic)
- fixcity.conf (missing .local)
- 000-default.conf (Apache default)
```

### Documentation Location

**Rule**: VHost documentation MUST exist in three locations:

1. **Project Level**: `docs/project/vhost-configuration.md`
2. **Modules Level**: `laravel/Modules/docs/vhost-configuration.md`
3. **Themes Level**: `laravel/Themes/docs/vhost-configuration.md`

**Rationale**:
- Discoverability: Docs near the code
- Redundancy: Multiple entry points
- Context: Different perspectives per layer

---

## 🔧 Setup Rules

### 1. Hosts File Entry

**Rule**: Local domains MUST be added to `/etc/hosts`

```bash
# ✅ CORRECT
127.0.0.1    fixcity.local
127.0.0.1    www.fixcity.local

# ❌ WRONG
127.0.0.1    fixcity
# (missing .local TLD)
```

### 2. Apache Module Requirements

**Rule**: Required Apache modules MUST be enabled

```bash
# Required modules
sudo a2enmod rewrite    # Laravel routing
sudo a2enmod ssl        # HTTPS (production)
sudo a2enmod headers    # Security headers

# ✅ Verify
apache2ctl -M | grep rewrite
```

### 3. Configuration Copy

**Rule**: After updating vhost config, MUST copy to Apache

```bash
# ✅ CORRECT WORKFLOW
1. Edit: laravel/config/vhost/fixcity.local.conf
2. Copy: sudo cp laravel/config/vhost/fixcity.local.conf /etc/apache2/sites-available/
3. Enable: sudo a2ensite fixcity.local.conf
4. Reload: sudo systemctl reload apache2

# ❌ WRONG
- Edit directly in /etc/apache2/sites-available/ (not versioned)
- Edit and forget to reload Apache (changes not applied)
```

---

## 🚫 Prohibited Patterns

### 1. Never Use `migrate:refresh` in Production

**Rule**: Database migrations MUST be forward-only

```bash
# ✅ CORRECT
php artisan migrate

# ❌ WRONG - Destroys data
php artisan migrate:refresh
php artisan migrate:fresh
php artisan migrate:rollback
```

**See**: `docs/leggi-ragiona-studia-docs.md`

### 2. Never Point DocumentRoot to `laravel/`

```apache
# ❌ CRITICAL SECURITY ISSUE
DocumentRoot /var/www/_bases/base_fixcity_fila5/laravel

# This exposes:
# - .env file
# - vendor/ directory
# - application code
# - database files
```

### 3. Never Disable `.htaccess`

```apache
# ❌ WRONG
AllowOverride None

# This breaks:
# - Laravel URL rewriting
# - Security rules
# - Cache control
```

---

## 🔒 Security Rules

### 1. Production HTTPS Rule

**Rule**: Production vhosts MUST use HTTPS

```apache
# ✅ PRODUCTION
<VirtualHost *:443>
    SSLEngine on
    SSLCertificateFile /path/to/cert.pem
    SSLCertificateKeyFile /path/to/key.pem
</VirtualHost>

# ❌ DEVELOPMENT ONLY
<VirtualHost *:80>
```

### 2. Security Headers Rule

**Rule**: Security headers SHOULD be added (optional in dev, mandatory in prod)

```apache
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

### 3. Environment Isolation Rule

**Rule**: Development vhosts MUST NOT connect to production databases

```env
# ✅ DEVELOPMENT
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/_bases/base_fixcity_fila5/laravel/database/fixcity_data.sqlite

# ❌ WRONG
DB_HOST=production-db.example.com
```

---

## 📊 Quality Gates

### Pre-Commit Checklist

Before committing vhost changes:

- [ ] Configuration file in `laravel/config/vhost/`
- [ ] Documentation updated in all 3 locations
- [ ] Apache syntax valid: `apache2ctl configtest`
- [ ] Logs configured
- [ ] Permissions correct
- [ ] Hosts file entry documented

### Testing Checklist

- [ ] `apache2ctl configtest` passes
- [ ] Site enabled: `a2ensite`
- [ ] Apache reloaded: `systemctl reload apache2`
- [ ] Domain resolves: `ping fixcity.local`
- [ ] Application accessible: `curl -I http://fixcity.local`
- [ ] Logs created: `ls -la /var/log/apache2/fixcity_*`

---

## 🔗 Related Documentation

### Internal

- [VHost Configuration Guide](../project/vhost-configuration.md) - Complete setup guide
- [Project Index](../index.md) - Main documentation
- [Modules Docs](../../Modules/docs/vhost-configuration.md) - Module perspective
- [Themes Docs](../../Themes/docs/vhost-configuration.md) - Theme perspective

### External

- [Apache VirtualHost Docs](https://httpd.apache.org/docs/2.4/vhosts/)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [OWASP Security Headers](https://owasp.org/www-project-secure-headers/)

---

## 📝 Enforcement

### Violation Handling

| Severity | Action |
|----------|--------|
| **Critical** (security) | Block merge, immediate fix required |
| **High** (functionality) | Fix before next commit |
| **Medium** (convention) | Fix within sprint |
| **Low** (style) | Technical debt backlog |

### Review Process

1. **Self-Review**: Check against this document
2. **Peer Review**: Team member validates
3. **CI/CD**: Automated checks (if configured)
4. **Merge**: Only after all checks pass

---

## 📞 Support

- **Slack**: #devops #infrastructure
- **GitHub**: Issue with label `infrastructure`
- **Team**: DevOps Team

---

**Maintainer**: DevOps Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Active  
**Enforcement**: Mandatory
