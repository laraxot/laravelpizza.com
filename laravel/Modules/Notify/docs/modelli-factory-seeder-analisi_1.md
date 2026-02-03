<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
# Analisi Modelli, Factory e Seeder - Modulo Notify

## Panoramica
Questo documento analizza tutti i modelli del modulo Notify verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core Notification (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Notification** | ✅ NotificationFactory | ❌ | Core - Notifiche sistema |
| **NotificationTemplate** | ✅ NotificationTemplateFactory | ❌ | Core - Template notifiche |
| **NotificationTemplateVersion** | ✅ NotificationTemplateVersionFactory | ❌ | Core - Versioning template |
| **NotificationType** | ✅ NotificationTypeFactory | ❌ | Core - Tipologie notifiche |

### Modelli Email System (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **MailTemplate** | ✅ MailTemplateFactory | ✅ MailTemplateSeeder | Core - Template email |
| **MailTemplateLog** | ✅ MailTemplateLogFactory | ❌ | Core - Log invii email |
| **MailTemplateVersion** | ✅ MailTemplateVersionFactory | ❌ | Core - Versioning email |

### Modelli Contact Management (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Contact** | ✅ ContactFactory | ❌ | Core - Contatti sistema |

### Modelli Theme System (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **NotifyTheme** | ✅ NotifyThemeFactory | ❌ | UI - Temi notifiche |
| **NotifyThemeable** | ✅ NotifyThemeableFactory | ❌ | UI - Applicazione temi |

### Modelli Base (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BasePivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseMorphPivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |

## Modelli Obsoleti/Problematici

### File .up (Temporanei/Backup)
| File | Stato | Motivazione |
|------|-------|-------------|
| **notificationlog.php.up** | 🗑️ Backup | File backup da rimuovere |
| **NotificationLog.php.up** | 🗑️ Backup | File backup da rimuovere |
| **notificationtemplateversion.php.up** | 🗑️ Backup | File backup da rimuovere |
| **NotificationTemplateVersion.php.up** | 🗑️ Backup | File backup da rimuovere |

## Analisi Dettagliata Modelli

### Sistema Notifiche Core

#### Notification - Notifiche Sistema
**Utilizzo**: Gestione notifiche in-app e push
**Caratteristiche**:
- **Multi-channel**: Email, SMS, Push, In-app
- **User Targeting**: Notifiche personalizzate per utente
- **Scheduling**: Programmazione invii
- **Status Tracking**: Monitoraggio stato notifiche
- **Priority System**: Sistema priorità notifiche

#### NotificationTemplate - Template Sistema
**Utilizzo**: Template riutilizzabili per notifiche
**Caratteristiche**:
- **Multi-format**: HTML, Plain Text, Markdown
- **Variable Replacement**: Sostituzione variabili dinamiche
- **Localization**: Supporto multi-lingua
- **Preview System**: Anteprima template
- **Validation**: Validazione sintassi template

#### NotificationTemplateVersion - Versioning
**Utilizzo**: Controllo versioni template notifiche
**Caratteristiche**:
- **Version Control**: Storico modifiche template
- **Rollback**: Ripristino versioni precedenti
- **A/B Testing**: Test versioni alternative
- **Approval Workflow**: Flusso approvazione modifiche

#### NotificationType - Tipologie
**Utilizzo**: Classificazione tipologie notifiche
**Caratteristiche**:
- **Category System**: Categorizzazione notifiche
- **User Preferences**: Preferenze utente per tipo
- **Channel Mapping**: Mapping tipo-canale
- **Frequency Control**: Controllo frequenza per tipo

### Sistema Email

#### MailTemplate - Template Email
**Utilizzo**: Template email sistema sanitario
**Caratteristiche**:
- **Medical Templates**: Template specifici sanitari
- **Appointment Reminders**: Promemoria appuntamenti
- **Report Notifications**: Notifiche referti
- **Emergency Alerts**: Allerte emergenza
- **Branding**: Template brandizzati per studio

#### MailTemplateLog - Log Invii
**Utilizzo**: Tracking completo invii email
**Caratteristiche**:
- **Delivery Status**: Stato consegna email
- **Open Tracking**: Tracking aperture email
- **Click Tracking**: Tracking click link
- **Bounce Handling**: Gestione email respinte
- **Spam Analysis**: Analisi spam score

#### MailTemplateVersion - Versioning Email
**Utilizzo**: Controllo versioni template email
**Caratteristiche**:
- **Template History**: Storico template email
- **Performance Tracking**: Tracking performance versioni
- **Compliance**: Conformità normative email
- **Backup System**: Backup template critici

### Sistema Contatti

#### Contact - Gestione Contatti
**Utilizzo**: Database contatti sistema
**Caratteristiche**:
- **Contact Management**: Gestione completa contatti
- **Segmentation**: Segmentazione contatti
- **Import/Export**: Import/export massivo
- **Deduplication**: Rimozione duplicati
- **GDPR Compliance**: Conformità privacy

### Sistema Temi

#### NotifyTheme - Temi Notifiche
**Utilizzo**: Temi visuali per notifiche
**Caratteristiche**:
- **Visual Themes**: Temi visuali personalizzati
- **Brand Consistency**: Coerenza brand
- **Responsive Design**: Design responsive
- **Dark/Light Mode**: Supporto temi scuri/chiari

#### NotifyThemeable - Applicazione Temi
**Utilizzo**: Relazione polimorfica per applicare temi
**Caratteristiche**:
- **Polymorphic Relations**: Applicazione a qualsiasi modello
- **Theme Inheritance**: Ereditarietà temi
- **Override System**: Sistema override personalizzazioni

## Seeder Mancanti Necessari

### Seeder Core da Creare
1. **NotificationSeeder** - Per notifiche di sistema base
2. **NotificationTemplateSeeder** - Per template notifiche standard
3. **NotificationTypeSeeder** - Per tipologie notifiche predefinite
4. **ContactSeeder** - Per contatti di test/demo

### Seeder Email da Creare
1. **MailTemplateLogSeeder** - Per log email di test (opzionale)
2. **MailTemplateVersionSeeder** - Per versioni template (opzionale)

### Seeder UI da Creare
1. **NotifyThemeSeeder** - Per temi predefiniti
2. **NotifyThemeableSeeder** - Per applicazioni tema esempio

## Factory Mancanti (Nessuna)
Tutti i modelli attivi hanno le factory corrispondenti.

## Raccomandazioni

### Azioni Immediate
1. **Rimuovere file .up**: Eliminare tutti i file backup .up
2. **Creare seeder core**: NotificationSeeder, NotificationTemplateSeeder, NotificationTypeSeeder
3. **Creare seeder temi**: NotifyThemeSeeder per temi base
4. **Documentare integrazione**: Aggiornare documentazione integrazioni

### Azioni Future
1. **Performance optimization**: Ottimizzare invio notifiche massive
2. **Analytics**: Implementare analytics notifiche
3. **A/B Testing**: Sistema test template avanzato
4. **Compliance**: Audit conformità normative email

## Struttura Seeder Esistenti

### Seeder Principali
- **NotifyDatabaseSeeder** - Seeder principale del modulo
- **MailTemplateSeeder** - Template email predefiniti
- **MailTemplatesSeeder** - Template email aggiuntivi (duplicato?)
- **DatabaseSeeder** - Seeder generale (da verificare)

### Duplicazioni da Risolvere
- **MailTemplateSeeder** vs **MailTemplatesSeeder**: Consolidare in uno

## Note Tecniche

### Pattern Architetturali
- **Observer Pattern**: Eventi notifiche automatiche
- **Strategy Pattern**: Diverse strategie invio (email, SMS, push)
- **Template Method**: Processing template notifiche
- **Chain of Responsibility**: Pipeline processing notifiche

### Canali di Notifica Supportati
- **Email**: SMTP, API services (Mailgun, SendGrid)
- **SMS**: API services (Twilio, Nexmo)
- **Push Notifications**: FCM, APNs
- **In-App**: Notifiche in-app real-time
- **Webhook**: Notifiche via webhook

### Sistema Template
- **Blade Templates**: Template Blade per email HTML
- **Markdown Support**: Template Markdown convertiti HTML
- **Variable Injection**: Sostituzione variabili dinamiche
- **Conditional Content**: Contenuto condizionale
- **Localization**: Template multi-lingua

### Integrazione Business Logic

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
#### <nome progetto> Integration
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
#### <nome progetto> Integration
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
#### <nome progetto> Integration
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
#### SaluteOra Integration
=======
#### <nome progetto> Integration
#### <nome progetto> Integration
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
#### SaluteOra Integration
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
#### SaluteOra Integration
>>>>>>> 8134673e1 (.)
=======
#### SaluteOra Integration
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
#### SaluteOra Integration
>>>>>>> 3808094f6 (.)
=======
#### <nome progetto> Integration
#### SaluteOra Integration
>>>>>>> 7ceb00286 (.)
- **Appointment Reminders**: Promemoria appuntamenti
- **Report Notifications**: Notifiche nuovi referti
- **Emergency Alerts**: Allerte mediche urgenti
- **Prescription Reminders**: Promemoria farmaci

#### User Integration  
- **Welcome Messages**: Messaggi benvenuto
- **Password Reset**: Email reset password
- **Account Verification**: Verifiche account
- **Security Alerts**: Allerte sicurezza

#### System Integration
- **Error Notifications**: Notifiche errori sistema
- **Maintenance Alerts**: Allerte manutenzione
- **Backup Status**: Status backup
- **Performance Alerts**: Allerte performance

### Validazione PHPStan
Tutti i file factory devono essere validati con PHPStan livello 9:
```bash
./vendor/bin/phpstan analyze Modules/Notify/database/factories --level=9
```

### Configurazione Email Templates

#### Template Medici Standard
- **appointment_reminder**: Promemoria appuntamento
- **appointment_confirmation**: Conferma appuntamento
- **appointment_cancellation**: Cancellazione appuntamento
- **report_ready**: Referto disponibile
- **prescription_ready**: Ricetta disponibile
- **emergency_alert**: Allerta emergenza

#### Template Sistema
- **welcome_email**: Email benvenuto
- **password_reset**: Reset password
- **account_verification**: Verifica account
- **security_alert**: Allerta sicurezza

## Collegamenti

### Documentazione Correlata
- [Notification System](./notification_system.md)
- [Email Templates](./email_templates.md)
- [Multi-Channel Delivery](./multi_channel_delivery.md)
- [Template Versioning](./template_versioning.md)

### Moduli Collegati
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [<nome progetto> Module](../../<nome progetto>/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 75179b855 (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 31f5d28f (.)
=======
>>>>>>> a404ea71 (.)
=======
>>>>>>> 4689a827 (.)
=======
>>>>>>> 6608a1a0 (.)
=======
>>>>>>> ca10d6ad (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 23cbbaf5 (.)
=======
>>>>>>> febe79e3 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 909e45af (.)
=======
>>>>>>> a29a4728 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bb7e77c2 (.)
=======
>>>>>>> c7a4727b (.)
=======
>>>>>>> b99af5a8 (.)
=======
>>>>>>> 9721a5b2 (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> f3086887 (rebase 210)
=======
>>>>>>> 1442e291 (rebase 210)
=======
- [<nome progetto> Module](../../<nome progetto>/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> e2f1a4045 (.)
=======
>>>>>>> c4282a934 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 01af324fe (.)
=======
>>>>>>> 8c6d84fe6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 53eef8d8d (.)
=======
>>>>>>> 753ea7aca (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 13aa25113 (.)
=======
>>>>>>> fdad57c30 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 7aae79847 (.)
=======
>>>>>>> 275b7ad99 (.)
=======
>>>>>>> 47bbf2b1c (.)
=======
>>>>>>> b215d516b (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 74eb2e964 (.)
=======
>>>>>>> f957fb24b (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 0a5473e16 (.)
=======
>>>>>>> 252fa579e (.)
=======
- [<nome progetto> Module](../../<nome progetto>/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 6ad5224fb (.)
=======
>>>>>>> 21a6fa9bc (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 610b999f1 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> ad905ce9c (.)
=======
>>>>>>> ff78f10a5 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> c7d5eaf96 (.)
=======
>>>>>>> a2f3c239e (.)
=======
>>>>>>> 1dc3e4fcd (.)
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
=======
- [<nome progetto> Module](../../<nome progetto>/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
- [<nome progetto> Module](../../../docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> bf479cc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> a2f3c239e (.)
=======
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 8134673e1 (.)
=======
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 763771402 (.)
=======
>>>>>>> 1dc3e4fcd (.)
=======
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 3808094f6 (.)
=======
- [<nome progetto> Module](../../<nome progetto>/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md) - Notifiche mediche
>>>>>>> 7ceb00286 (.)
- [User Module](../../User/docs/modelli_factory_seeder_analisi.md) - Notifiche utente
- [Media Module](../../Media/docs/modelli_factory_seeder_analisi.md) - Allegati notifiche
- [Lang Module](../../Lang/docs/modelli_factory_seeder_analisi.md) - Localizzazione

### Servizi Esterni
- [Mailgun](https://www.mailgun.com/) - Email delivery service
- [SendGrid](https://sendgrid.com/) - Email platform
- [Twilio](https://www.twilio.com/) - SMS service
- [Firebase](https://firebase.google.com/) - Push notifications

*Ultimo aggiornamento: Gennaio 2025*
*Analisi completa di 10 modelli attivi, 4 file backup da rimuovere*
*Sistema notifiche multi-canale completo*
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> c4bdacbf (.)
=======
>>>>>>> bd804d67 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
