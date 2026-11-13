# 📧 BMAD Story: Email Deliverability Setup

> **Valori non verificati (2026-11-12).** Gli esempi qui sotto non sono misure: l'IP SPF `185.71.12.45`, i parametri `postconf dkim_*` e il DMARC `p=quarantine` immediato non vengono da DNS o dal server. Il dominio invia via Mailtrap con DMARC `p=none` in osservazione: valori e stato reali in [mail-deliverability.md](../../mail-deliverability.md) (e `php artisan notify:check-dns`). Lo «stato operativo» dichiarato sotto non regge: i 4 CNAME Mailtrap sono pubblicati senza punto finale.

**Story ID**: BMAD-EMAIL-001  
**Epic**: Email Infrastructure  
**Module**: Notify (owner)  
**Status**: ✅ READY FOR DEV  
**Priority**: P0 (Critical)  
**Date**: 2026-11-12

---

## 📋 Story Summary

> As a **System Administrator**, I want to **configure email deliverability** so that **emails sent from FixCity never land in Spam**.

---

## 🎯 Acceptance Criteria

- [ ] SPF record configured and verified for `fixcity.eu`
- [ ] DKIM key generated (2048-bit RSA) and published in DNS
- [ ] DMARC policy set to `p=quarantine` with reporting
- [ ] `MAIL_FROM_ADDRESS` uses verified domain
- [ ] All Mailable classes include `List-Unsubscribe` header
- [ ] Rate limiting configured (< 100 emails/min per IP)
- [ ] Bounce/complaint webhooks registered and tested
- [ ] Test emails sent successfully to Gmail, Outlook, Apple Mail
- [ ] Spam score < 3 (SpamAssassin) for all templates
- [ ] Documentation created in all modules and themes

---

## 🔧 Technical Requirements

### 1. DNS Configuration

| Record Type | Host | Value | TTL |
|-------------|------|-------|-----|
| TXT (SPF) | `fixcity.eu` | `v=spf1 ip4:185.71.12.45 include:_spf.google.com ~all` | 3600 |
| TXT (DKIM) | `default._domainkey.fixcity.eu` | `v=DKIM1; k=rsa; p=MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA...` | 3600 |
| TXT (DMARC) | `_dmarc.fixcity.eu` | `v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu; ruf=mailto:dmarc@fixcity.eu; fo=1` | 3600 |

### 2. Laravel Configuration

```bash
# .env
MAIL_MAILER="sendmail"              # or "mailtrap-sdk" for testing
MAIL_FROM_ADDRESS="noreply@fixcity.eu"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_SENDMAIL_PATH="/usr/sbin/sendmail -t -i"
```

### 3. Postfix Configuration

```bash
# /etc/postfix/main.cf
myhostname = fixcity.eu
mydomain = fixcity.eu
mydestination = $myhostname, localhost.$mydomain, localhost
mynetworks = 127.0.0.0/8 [::ffff:127.0.0.1]/104 [::1]/128
relayhost =
dkim_key_file = /etc/ssl/private/dkim.private
dkim_selector = default
dkim_domain = fixcity.eu
dkim_signature_headers = "From:To:Subject:Message-ID:Date"
```

---

## 📦 Dependencies

- `symfony/mailer: ^8.1`
- `railsware/mailtrap-php: ^3.18`
- `spatie/laravel-database-mail-templates: *`
- `spatie/laravel-queueable-action: *`
- `nyholm/psr7: ^1.8`
- `symfony/http-client: ^8.1`

---

## 🔗 Related Stories

- **BMAD-EMAIL-002**: Email Template System Setup
- **BMAD-EMAIL-003**: Email Widget Filament Blueprint
- **BMAD-EMAIL-004**: Bounce and Complaint Handling

---

## 📝 Notes

- DKIM keys should be rotated every 6 months
- DMARC reports should be reviewed monthly
- SPF records should be updated when new sending IPs are added
- Mailtrap sandbox is for testing only; production requires verified domain

---

## ✅ Definition of Done

- [ ] All DNS records published and verified
- [ ] Postfix configured with DKIM signing
- [ ] Laravel mailers configured and tested
- [ ] All Mailable classes include unsubscribe header
- [ ] Rate limiting middleware active
- [ ] Monitoring dashboard operational
- [ ] Documentation published in all modules and themes
- [ ] CI/CD pipeline includes email deliverability checks

---

*BMAD Story – Email Deliverability Setup – P0 Critical*  
*Created: 2026-11-12*  
*Owner: Notify Module*