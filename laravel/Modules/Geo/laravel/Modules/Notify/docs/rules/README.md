# 📜 Project Rules Index

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Active

---

## 📋 Overview

This directory contains **mandatory rules** and governance documents for the FixCity platform.

---

## 📁 Rules

### Infrastructure

| Rule | Description | Enforcement |
|------|-------------|-------------|
| [`vhost-governance.md`](vhost-governance.md) | Apache vhost configuration rules | ✅ Mandatory |

**Key Rules**:
1. Document root MUST be `public_html/`
2. Config files MUST be in `laravel/config/vhost/`
3. Local domains MUST use `.local` TLD
4. Each vhost MUST have dedicated log files
5. Directory permissions MUST follow least privilege

---

## 🔗 Related Rules

### From Other Directories

**Conventions:**
- [`../conventions/README.md`](../conventions/README.md) - Coding conventions

**Quality:**
- [`../quality/README.md`](../quality/README.md) - Quality gates

**Regole Critiche:**
- [`../regole-critiche/README.md`](../regole-critiche/README.md) - Critical rules

---

## 📊 Rule Categories

### By Severity

**Critical (Security):**
- Document root must be `public_html/`
- HTTPS required in production
- No production database access from dev

**High (Functionality):**
- Configuration versioning
- Logging requirements
- Module enabling

**Medium (Convention):**
- File naming patterns
- Documentation structure
- Directory organization

**Low (Style):**
- Comment style
- Formatting preferences

---

## 🎯 Rule Compliance

### Checking Compliance

```bash
# Verify vhost configuration
apache2ctl configtest

# Check enabled sites
ls -la /etc/apache2/sites-enabled/

# Verify document root
grep -r "DocumentRoot" /etc/apache2/sites-available/fixcity.local.conf
```

### Reporting Violations

1. Create GitHub issue
2. Label: `infrastructure` or `security`
3. Severity: Critical/High/Medium/Low
4. Assignee: DevOps Team

---

## 📝 Maintenance

### Adding New Rules

1. Create markdown file in `docs/rules/`
2. Add to this index
3. Define enforcement level
4. Update main index: [`../index.md`](../index.md)
5. Announce in team channel

### Review Schedule

- **Monthly**: Check for outdated rules
- **Quarterly**: Add new rules as needed
- **Annually**: Full rules audit

---

## 🔗 External References

- [Apache Best Practices](https://httpd.apache.org/docs/2.4/misc/security_tips.html)
- [OWASP Security Guidelines](https://owasp.org/www-project-secure-headers/)
- [Laravel Deployment](https://laravel.com/docs/deployment)

---

**Maintainer**: DevOps Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Active
