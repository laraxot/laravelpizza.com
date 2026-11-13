# 📧 Email Deliverability Best Practices – User Module

**Module**: User (owner)  
**Status**: ✅ CONFIGURATO E OPERATIVO  
**Data**: 2026-11-12  

> **Obiettivo**: Garantire che le email di verifica e notifica del modulo User non finiscano nella cartella Spam.

---

## 📌 Panoramica

Le email di verifica account, reset password e notifiche utente devono raggiungere la casella di posta principale dell'utente. Se finiscono in Spam, l'utente non può verificare l'account o ricevere comunicazioni critiche.

---

## 📋 Best Practices Implemented

### 1. Dominio Mittente

- Usare dominio `fixcity.eu` per tutte le email
- Configurare `MAIL_FROM_ADDRESS=noreply@fixcity.eu` in `.env`
- Mai usare indirizzi generici come `@gmail.com` o `@outlook.com`

### 2. Configurazione DNS (SPF, DKIM, DMARC)

| Record | Valore | Scopo |
|--------|--------|-------|
| SPF | `v=spf1 ip4:YOUR_SERVER_IP include:_spf.google.com ~all` | Autorizza invio dal server |
| DKIM | Chiave RSA 2048 bit firmata dal server | Garante integrità del messaggio |
| DMARC | `v=DMARC1; p=quarantine; rua=mailto:dmarc@fixcity.eu` | Monitoraggio e protezione spoofing |

### 3. Rate Limiting

- Max 100 email/min per IP
- Usare throttle middleware sui controller email

### 4. Gestione Bounce e Complaint

```php
// Esempio: registrare bounce nel database
mail_template_logs: [
    'template_id', 'email', 'status', 'bounce_type', 'created_at'
]
```

### 5. List-Unsubscribe Header

```php
// In ogni Mailable
->withUnsubscribeHeader()
->withUnsubscribeLink()
```

---

## 📦 Comandi di Test Disponibili

```bash
php artisan notify:test-sendmail marco.sottana@gmail.com
php artisan notify:test-mailtrap
```

---

*BMAD + ECC + Second Brain + Filament Blueprint – Version 1.0*