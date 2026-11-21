---
issues: []
discussions: []
title: "Notify — scopo, confini e come servirlo meglio"
type: concept
module: Notify
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, servizio-trasversale, canali, notifiche, dipendenze]
qmd: "scopo notify servizio trasversale canali notifiche email sms whatsapp telegram push confini dipendenze ipertrofia documentale"
---

# Notify — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Notify non ha un dominio applicativo. Non esiste una "pratica di notifica" da istruire,
approvare o archiviare: esiste solo il momento in cui un altro modulo ha già deciso che
qualcosa va comunicato, e serve qualcuno che sappia come farlo arrivare. Il codice lo
dice con precisione: `app/Actions/` contiene 46 file e **tutti e 46 usano
`Spatie\QueueableAction\QueueableAction`** — non c'è una sola classe che rappresenti un
oggetto di business, ci sono solo verbi accodabili.

Quei verbi sono organizzati per corriere, non per contenuto:

| Cartella | File | Cosa consegna |
|---|---:|---|
| `app/Actions/SMS/` | 11 | Agiletelecom (v1/v2), Gammu, Netfun, Nexmo, Plivo, SmsFactor, Twilio |
| `app/Actions/Push/` | 8 | FCM: device singolo, lista, topic, piattaforma, targeting, template, schedulazione |
| `app/Actions/WhatsApp/` | 4 | 360dialog, Facebook, Twilio, Vonage |
| `app/Actions/Mail/` | 4 (+ `Engines/`) | SMTP, Mailtrap, layout, invio con template |
| `app/Actions/Telegram/` | 3 | Botman, Nutgram, API ufficiale |

Sette provider SMS diversi per lo stesso identico atto — mandare un messaggio a un
numero — sono la prova che il criterio organizzativo del modulo è la
**sostituibilità del corriere**, non la ricchezza del messaggio. Lo confermano i
quattro `app/Channels/` (`NetfunChannel`, `SmsChannel`, `TelegramChannel`,
`WhatsAppChannel`), che agganciano quei verbi al sistema di notifiche di Laravel, e i
`app/Datas/` (27 file Spatie Data: `SmsData`, `WhatsAppData`, `TelegramData`,
`SmtpData`, `PushNotificationData`) che tipizzano il payload prima che tocchi la rete.

Da qui la formulazione in una riga:

> **Notify è il livello di trasporto delle comunicazioni verso l'esterno: sa come si
> consegna un messaggio su cinque canali e con quale provider, e non sa nulla del
> perché quel messaggio esista.**

Il "perché" resta fuori: delle 23 classi `Notification` del repo, 19 stanno in Notify —
ma le 4 che contano davvero per il dominio (`Ptv`, `Progressioni`, `User`, `Job`) stanno
nei moduli che generano l'evento, e Notify le riceve. `RecordNotification` è il punto di
giunzione: è il simbolo di Notify più importato dagli altri (4 file).

I consumatori, misurati il 2026-09-02 con
`grep -rl 'Modules\\Notify\\' Modules/<Modulo>` (esclusi `docs/`, `vendor/`,
`node_modules/`):

| Modulo | File | Cosa importa |
|---|---:|---|
| IndennitaResponsabilita | 9 | `RecordNotification`, `MailTemplateResource`, `SpatieEmail` |
| Progressioni | 6 | idem |
| Xot | 4 | `RecordNotification` in `XotBaseTransition` |
| Ptv | 3 | `SendMailByRecord` |
| Pdnd | 2 | |
| User | 1 | |

Sei moduli su diciassette. Non è una piattaforma consumata ovunque come Xot: è un
servizio usato dai moduli che hanno un flusso con destinatari umani. Il punto di
aggancio più profondo è `Modules/Xot/app/States/Transitions/XotBaseTransition.php:113`
— ogni transizione di stato della piattaforma può notificare, e passa di qui.

## I confini, e dove oggi sono rotti

### La documentazione ha smesso di essere proporzionata al codice

| Misura | `app/` | `docs/` | Rapporto |
|---|---:|---:|---:|
| File | 232 `.php` | 3.031 `.md` | **13 : 1** |
| Righe | 17.341 | 804.192 | **46 : 1** |

Quarantasei righe di documentazione per ogni riga di codice non sono una virtù. Il
sospetto che sia ipertrofia e non ricchezza è confermato da tre misure indipendenti:

- **899 nomi di file collidono**: 3.031 file `.md`, solo 2.132 basename distinti.
- **83 gruppi di file byte-identici**: `find docs -name '*.md' -exec md5sum {} + | awk '{print $1}' | sort | uniq -d | wc -l`.
- **25 directory contengono sia `00-index.md` sia `00-index.md`** — due indici per la
  stessa cartella, distinti solo dal case, quindi due verità che nessuno riconcilia.
  Su un filesystem case-insensitive uno dei due sparisce e nessuno se ne accorge.
- **1.059 file `.md` stanno piatti nella root di `docs/`**, oltre un terzo del totale,
  senza gerarchia che ne dichiari il proprietario.

Non è un problema estetico: 804.192 righe indicizzate da QMD e dal knowledge graph
sono contesto che gli agenti pagano a ogni ricerca, e 83 duplicati esatti significano
che una regola corretta e una sua copia obsoleta hanno lo stesso peso nel ranking.

Anche il README del modulo ne risente: dichiara "File PHP / righe di codice: 720 /
54.927" attribuendolo al comando `find app -name '*.php' | xargs wc -l`. Il comando
citato, eseguito il 2026-09-02, restituisce **232 file e 17.341 righe**; 701 file e
54.098 righe sono la misura dell'**intero modulo** (`app/` + `tests/` + seeders +
factories). Il numero non è inventato, è etichettato male — ma un numero con il comando
sbagliato accanto è esattamente il difetto che quel README dichiara di voler evitare.

### Tre modelli sono fuori dalla connection del modulo

`app/Models/BaseModel.php:22` dichiara `protected $connection = 'notify'`. Tre modelli
concreti su quattordici non lo ereditano perché estendono direttamente
`Illuminate\Database\Eloquent\Model`:

| Modello | Migrazione | Effetto |
|---|---|---|
| `NotificationType` | `2026_03_03_000001_create_notification_types_table.php` | `XotBaseMigration` risolve la connection dal modello: `notification_types` finisce sulla connection **di default**, non su `notify` |
| `Theme` | nessuna | tabella inesistente; `tests/Feature/ThemeManagementBusinessLogicTest.php:15` lo dichiara: *"The tests reference Modules\Notify\Models\Theme which is not implemented"* |
| `EmailTemplate` | nessuna | idem, e coesiste con `MailTemplate` che invece è reale, versionato e loggato |

`Theme` e `NotifyTheme` sono due modelli per lo stesso concetto: solo il secondo ha
migrazione (`create_notify_themes_table`), factory, seeder e Filament Resource.
`EmailTemplate` e `MailTemplate` sono la stessa coppia sul lato email. In entrambi i
casi il modello vivo è quello con la migrazione; l'altro è un abbozzo che PHPStan
analizza, l'IDE completa e un agente può usare in buona fede.

### `app/Services/` esiste ancora, e duplica `app/Actions/`

La policy del progetto (`bashscripts/ai/wiki/rules/no-services-rule.md`) vieta
`app/Services` e le classi `*Service`. In Notify ci sono 4 file `.php` più un residuo:

```
app/Services/NotificationManager.php        <- duplicato di app/Actions/NotificationManager.php
app/Services/PushNotificationService.php
app/Services/SmsService.php
app/Services/MailEngines/MailtrapEngine.php
app/Services/MailService.to_action          <- non è PHP: è un promemoria di conversione
```

`NotificationManager` esiste due volte con la **stessa firma di `send()`**
(`Model $recipient, string $templateCode, array $data, array $channels, array $options`).
La copia in `app/Actions/` usa `QueueableAction` e delega, quella in `app/Services/` no.
Due classi con lo stesso nome e la stessa firma in due namespace è la condizione
esatta in cui un `use` sbagliato non produce nessun errore, solo un comportamento
diverso.

### Contratti duplicati con nome diverso

`app/Contracts/` contiene tre coppie in cui `*Contract` e `*Interface` dichiarano i
**metodi identici**:

| Coppia | Metodi |
|---|---|
| `NotificationDispatcherContract` / `NotificationDispatcherInterface` | `dispatch()`, `broadcast()` |
| `TelegramProviderActionContract` / `TelegramProviderActionInterface` | `execute(TelegramData): array` |
| `WhatsAppProviderActionContract` / `WhatsAppProviderActionInterface` | `execute(WhatsAppData): array` |

Un'interfaccia serve a dire "chiunque implementi questo è intercambiabile". Due
interfacce identiche dicono il contrario: che ci sono due famiglie di implementatori
che non lo sono.

### Il pannello admin espone 15 pagine di test, 4 delle quali in doppia copia

`app/Filament/Clusters/Test/Pages/` contiene 15 pagine (`SendEmailPage`, `SendSmsPage`,
`TestSmtpPage`, `SendWhatsAppPage`, `SendTelegramPage`, `SendAwsEmailPage`,
`SendFirebasePushNotificationPage`, ...). Quattro esistono due volte, con e senza il
suffisso `Page`:

| Coppia | Righe | Righe di `diff` |
|---|---|---:|
| `SendEmail.php` / `SendEmailPage.php` | 114 / 126 | 58 |
| `SendTelegram.php` / `SendTelegramPage.php` | 143 / 153 | 211 |
| `SendPushNotification.php` / `SendPushNotificationPage.php` | 243 / 245 | 12 |
| `SlackNotification.php` / `SlackNotificationPage.php` | 17 / 17 | 4 |

Non sono copie identiche: sono **fork divergenti**. La versione senza `Page` e quella
con `Page` hanno preso strade diverse, e nessun commento dice quale sia quella buona.

### 22 file in `app/` non sono PHP

`find app -type f ! -name '*.php' ! -name '.gitkeep'` ne conta 22: 8 `.up`, 8 `.test`,
3 `_components.json`, 1 `.wip`, 1 `.to_action`, 1 `.md`. Fra questi
`app/Models/notificationlog.php.up`, `app/Filament/Resources/NotificationTemplateResource.php.up`
e `app/Filament/Resources/MailTemplateResource/RelationManagers/VersionsRelationManager.php.up`,
che affiancano la versione `.php` viva. Sono copie di lavoro congelate dentro il
namespace di produzione: invisibili all'autoloader, visibili a `grep`, e quindi a
qualunque agente che cerchi "come si fa X in Notify".

## Come servire meglio lo scopo

### 1. Riportare i tre modelli orfani sotto `BaseModel`, o cancellarli

File: `app/Models/NotificationType.php`, `app/Models/Theme.php`,
`app/Models/EmailTemplate.php`.

`NotificationType` ha una migrazione e va corretto: `extends BaseModel` gli dà la
connection `notify` e allinea tabella e modello. `Theme` ed `EmailTemplate` non hanno
migrazione, non hanno consumatori fuori dai test, e hanno ciascuno un gemello reale
(`NotifyTheme`, `MailTemplate`): vanno cancellati, non "completati". Il test
`tests/Feature/ThemeManagementBusinessLogicTest.php` che documenta l'assenza di `Theme`
va rimosso con lui.

```bash
cd laravel
grep -rn 'extends Model$' Modules/Notify/app/Models   # obiettivo: 0
```

### 2. Fondere `NotificationManager` e sciogliere `app/Services/`

File: `app/Services/NotificationManager.php` (da cancellare),
`app/Actions/NotificationManager.php` (da tenere),
`app/Services/PushNotificationService.php` e `app/Services/SmsService.php` (da
convertire in Action `execute()`), `app/Services/MailEngines/MailtrapEngine.php` (da
spostare sotto `app/Actions/Mail/Engines/`, dove `MailEngines` ha già un gemello),
`app/Services/MailService.to_action` (da cancellare: è un promemoria, non codice).

Prima di convertire va verificato che non siano proxy di relazioni Eloquent già
esistenti: in quel caso si cancellano.

```bash
cd laravel
find Modules/Notify/app/Services -type f ! -name '.gitkeep' | wc -l   # obiettivo: 0
```

### 3. Tenere un solo nome per ogni contratto

File: i tre `app/Contracts/*Interface.php`. La convenzione del progetto è `*Contract`
(`Xot\Contracts\ProfileContract`, `Xot\Contracts\UserContract`): si tengono i
`*Contract` e si cancellano i tre `*Interface`, aggiornando gli `implements`.

```bash
cd laravel
ls Modules/Notify/app/Contracts | grep -c 'Interface.php'   # obiettivo: 0
./vendor/bin/phpstan analyse Modules/Notify                 # deve restare a 0 errori
```

### 4. Scegliere una copia per ognuna delle 4 pagine di test duplicate

File: `app/Filament/Clusters/Test/Pages/{SendEmail,SendTelegram,SendPushNotification,SlackNotification}.php`
contro le rispettive `*Page.php`. Il `diff` fra le due copie va letto una volta sola,
si tiene quella registrata nel cluster e si cancella l'altra. La regola da lasciare
scritta è il suffisso: in Filament una pagina si chiama `*Page`.

```bash
cd laravel
find Modules/Notify/app/Filament/Clusters/Test/Pages -name '*.php' | wc -l   # 15 oggi, 11 dopo
```

### 5. Deduplicare `docs/` prima di aggiungere una sola riga nuova

Target misurabili, nell'ordine: gli 83 gruppi di file identici, le 25 collisioni
`00-index.md` / `00-index.md`, i 1.059 file piatti nella root. Le regole di progetto sui
nomi dei file markdown esistono già — anzi ne esistono troppe, `ls docs/wiki/rules/ |
grep -ci markdown` ne conta 9 — e qui vanno applicate, non riscritte una decima volta.

```bash
cd laravel/Modules/Notify
find docs -name '*.md' -type f -exec md5sum {} + | awk '{print $1}' | sort | uniq -d | wc -l  # 83 -> 0
find docs -iname '00-index.md' | sed 's|/[^/]*$||' | sort | uniq -d | wc -l                  # 25 -> 0
ls docs/*.md | wc -l                                                                          # 1059 -> ?
```

## Cosa NON è compito di Notify

- **Non** decide *se* una notifica va inviata. Quella scelta appartiene al modulo che
  possiede lo stato: `Xot\States\Transitions\XotBaseTransition`,
  `Ptv\Actions\Scheda\SendMailByRecord`, `User\Actions\Otp\SendOtpByUserAction`. Notify
  riceve un destinatario e un messaggio già decisi.
- **Non** conosce il dominio del messaggio. Non sa cos'è una scheda, una progressione o
  un'indennità: se una classe di Notify nomina un concetto di un modulo foglia, quella
  classe è nel posto sbagliato.
- **Non** possiede l'anagrafica dei destinatari. `Contact` è la rubrica dei recapiti di
  notifica, non il profilo: l'identità sta in `User`/`Xot\Contracts\ProfileContract`, ed
  è così che i 10 file di Notify che tipizzano un profilo lo fanno già oggi.
- **Non** è un modulo di dominio, quindi **non** ha una tabella `mylog` propria: il log
  per modulo appartiene ai moduli con un flusso da tracciare (Ptv, Performance,
  Progressioni, Indennita*). Il tracciamento delle consegne di Notify sta in
  `notification_logs`, che è un'altra cosa: dice se il corriere ha consegnato, non cosa
  ha fatto un utente.
- **Non** genera contenuto. I template (`MailTemplate`, `NotificationTemplate` e le loro
  `*Version`) sono contenitori con segnaposto; chi riempie i segnaposto è il chiamante.

## Verifica

```bash
cd laravel

# scopo: un servizio di trasporto, non un dominio
find Modules/Notify/app/Actions -name '*.php' | wc -l                      # 46
grep -rl 'QueueableAction' Modules/Notify/app/Actions | wc -l              # 46 (tutte accodabili)

# confini: modelli fuori connection
grep -rn 'extends Model$' Modules/Notify/app/Models                        # obiettivo: nessun risultato

# confini: policy no-services
find Modules/Notify/app/Services -type f ! -name '.gitkeep' | wc -l        # obiettivo: 0

# confini: contratti duplicati
ls Modules/Notify/app/Contracts | grep -c 'Interface.php'                  # obiettivo: 0

# confini: residui di lavorazione nel namespace di produzione
find Modules/Notify/app -type f ! -name '*.php' ! -name '.gitkeep' | wc -l # 22 -> 0

# proporzione documentazione/codice
find Modules/Notify/app  -name '*.php' -print0 | xargs -0 cat | wc -l      # 17341
find Modules/Notify/docs -name '*.md'  -print0 | xargs -0 cat | wc -l      # 804192
find Modules/Notify/docs -name '*.md' -type f -exec md5sum {} + \
  | awk '{print $1}' | sort | uniq -d | wc -l                              # 83 gruppi identici

./vendor/bin/phpstan analyse Modules/Notify                                # deve restare a 0 errori
```

## Collegamenti

- [README.md](../README.md) — badge e stato misurato del modulo
- [no-services-rule](../../../../bashscripts/ai/wiki/rules/no-services-rule.md) — perché `app/Services` non deve esistere
- [migration-filename-from-model-name](../../../../docs/wiki/rules/migration-filename-from-model-name.md) — N modelli = N migrazioni, nome dal modello
- [markdown-filename-conventions](../../../../docs/wiki/rules/markdown-filename-conventions.md) — una delle 9 regole sui nomi dei file `.md`
- [Sigma/docs/scopo.md](../../Sigma/docs/scopo.md) — il modello di questo documento
