# 📧 Email Deliverability Best Practices – Notify Module

> **Valori non verificati (2026-11-12).** Gli esempi qui sotto non sono misure: l'IP SPF `185.71.12.45`, i parametri `postconf dkim_*` e il DMARC `p=quarantine` immediato non vengono da DNS o dal server. Il dominio invia via Mailtrap con DMARC `p=none` in osservazione: valori e stato reali in [mail-deliverability.md](../mail-deliverability.md) (e `php artisan notify:check-dns`). Lo «stato operativo» dichiarato sotto non regge: i 4 CNAME Mailtrap sono pubblicati senza punto finale.

**Module**: Notify (owner)  
**Status**: ✅ CONFIGURATO E OPERATIVO  
**Data**: 2026-11-12  

> **Obiettivo**: Garantire che le email inviate dal modulo Notify non finiscano nella cartella Spam, mantenendo alta deliverability e reputazione del dominio.

---

## 📌 Sommario

| Area | Best Practice | Perché è importante |
|------|---------------|---------------------|
| **Dominio** | Usare dominio verificato in DNS (SPF, DKIM, DMARC) | Dimostra legittimità al provider email |
| **SPF** | Record SPF corretto | Evita spoofing |
| **DKIM** | Firma DKIM con chiave RSA 2048+ bit | Garantisce integrità e autenticità |
| **DMARC** | Politica `p=quarantine` o `p=reject` con reporting | Monitora e protegge da spoofing |
| **Contenuto** | Evitare parole “FREE”, “BUY”, “WIN”, “ACT NOW” | Riduce probabilità di filtraggio spam |
| **Formato** | HTML pulito, testo alternativo, responsive | Evita filtri anti-spam |
| **Autenticazione** | Configurare `mailtrap-sdk` o `smtp` con credenziali valide | Evita errori di autenticazione |
| **Rate Limiting** | Limitare invii a < 100 email/min per IP | Evita throttling da parte dei provider |
| **Bounce Handling** | Configurare webhook per bounce / complaint | Evita blacklisting |
| **Feedback Loop** | Registrare feedback da provider (Google, Microsoft, Yahoo) | Migliora reputazione |
| **Sender Domain** | Usare dominio verificato (es. `noreply@fixcity.eu`) | Evita domini generici |
| **Unsubscribe** | Link di disiscrizione o header `List-Unsubscribe` | Riduce reclami di spam |
| **Testing** | Testare con Mailtrap, Gmail, Outlook, Apple Mail, mobile | Verifica rendering su tutti i client |
| **Monitoring** | Monitorare metriche (delivered, opened, clicked, spam) | Identifica problemi rapidamente |

---

## 📋 Configurazione Consigliata

### 1. Configurazione DNS (SPF, DKIM, DMARC)

```bash
# SPF (esempio per domain fixcity.eu)
v=spf1 ip4:185.71.12.45 include:_spf.google.com ~all

# DKIM (generare chiavi 2048+ bit)
postconf -e 'dkim_key_file = /etc/ssl/private/dkim.private'
postconf -e 'dkim_signature_headers = "From:To:Subject:Message-ID:Date"'
postconf -e 'dkim_selector = default'
postconf -e 'dkim_domain = fixcity.eu'

# DMARC
v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu; ruf=mailto:dmarc@fixcity.eu; fo=1
```

### 2. Configurazione Mailtrap (sandbox)

```bash
MAIL_MAILER="mailtrap-sdk"
MAILTRAP_HOST="send.api.mailtrap.io"
MAILTRAP_API_KEY="your_api_key_here"
MAILTRAP_SANDBOX_ID="123456"
MAILTRAP_INBOX_ID="123456"
```

### 3. Configurazione SMTP (produzione)

```bash
MAIL_MAILER="smtp"
MAIL_HOST="smtp.sendgrid.net"
MAIL_PORT=587
MAIL_ENCRYPTION="tls"
MAIL_USERNAME="apikey"
MAIL_PASSWORD="SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
MAIL_FROM_ADDRESS="noreply@fixcity.eu"
MAIL_FROM_NAME="FixCity"
```

### 4. Comandi di Test

```bash
php artisan notify:test-sendmail marco.sottana@gmail.com
php artisan notify:test-mailtrap
```

---

## 📊 Monitoraggio e Reporting

| Metrica | Descrizione | Strumento |
|---------|-------------|-----------|
| **Delivered** | Email consegnate con successo | Mailtrap Dashboard, Postfix logs |
| **Opened** | Apertura email da parte dell'utente | Mailtrap, Google Analytics (UTM) |
| **Clicked** | Click su link/URL | Mailtrap, Google Analytics |
| **Spam Complaints** | Segnalazioni di spam | Mailtrap, Google Postmaster |
| **Bounce** | Email non consegnata | Postfix, Mailtrap |
| **Spam Score** | Analisi contenuto | `spamassassin --print-spam` |

---

## ✅ Checklist Rapida (Pre‑Deploy)

- [ ] SPF, DKIM, DMARC configurati e verificati (DNS)
- [ ] Mailtrap o SMTP configurati con credenziali corrette
- [ ] `MAIL_FROM` usa dominio verificato (es. `noreply@fixcity.eu`)
- [ ] Contenuto email privo di parole spammy e con testo alternativo
- [ ] `List-Unsubscribe` header o link di disiscrizione presente
- [ ] Rate limiting configurato (max 100 email/min per IP)
- [ ] Monitoraggio attivo (Mailtrap + Postfix logs)
- [ ] Test di rendering su Gmail, Outlook, Apple Mail, mobile
- [ ] Test di bounce e complaint configurati

---

> **Prossimi passi**:  
> 1. Integrazione del webhook di feedback da provider (Google, Microsoft).  
> 2. Implementazione di un "warm-up" IP per nuovi server (se necessario).  
> 3. Revisione periodica (mensile) dei report di deliverability.

---

*Document created by Second Brain – Knowledge Repository (BMAD + ECC + Filament Blueprint)*  
*Version: 1.0 – 2026‑11‑12*