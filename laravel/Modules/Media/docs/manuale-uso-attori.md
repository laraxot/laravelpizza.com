---
title: "Manuale d'uso per attori - Media"
module: Media
type: manuale-uso
---

# Modulo Media

## Scopo

Media gestisce upload, allegati, storage, conversioni di immagini e video,
metadati e distribuzione tramite storage/CDN. È un modulo infrastrutturale:
le applicazioni ospitanti lo usano attraverso Actions, modelli e componenti
Filament.

## Matrice attori

| Attore | Accesso o responsabilità verificata |
|---|---|
| Ospite | N/A per la gestione del modulo. Lo streaming richiede controllo di autenticazione quando il media è noto. |
| Utente autenticato | Può operare sui media solo tramite le abilità/permessi assegnati (`media.*`, `media_convert.*`, `temporary_upload.*`) e i form del modulo ospitante. |
| Gruppo/ruolo | `media::admin` supera le policy del modulo; gli altri accessi passano dalle abilità specifiche. |
| Admin | N/A come ruolo generico separato: il codice espone `media::admin`. |
| Super-admin | Bypass delle policy Media e accesso alla pagina impostazioni. |
| Operatore | N/A. |

## Flussi reali

1. Un form ospitante usa `GetAttachmentsSchemaAction`/`AddAttachmentAction` per
   validare e allegare file.
2. Gli upload temporanei vengono associati alla sessione e poi salvati dal
   record tramite `SaveAttachmentsAction`.
3. Media e conversioni sono gestiti dalle Resource Filament del modulo.
4. Le conversioni video usano le Actions dedicate; le integrazioni S3 e
   CloudFront espongono Actions diagnostiche e di storage.
5. Il super-admin modifica dimensione massima e MIME type dalla `SettingPage`.

## Prerequisiti

- Moduli User, Xot e Tenant caricati.
- Configurazione del filesystem/storage e, se usati, S3, FFmpeg o CDN.
- Autenticazione e permessi Spatie per le operazioni non coperte dal ruolo
  `media::admin`.
- Un modello ospitante che integri il contratto/trait media richiesto.

## Limiti

- Le route `web.php` e `api.php` del modulo sono vuote: non esiste un portale
  pubblico Media autonomo.
- Il modulo non definisce un ruolo operativo dedicato.
- Le pagine diagnostiche storage espongono operazioni sensibili e vanno trattate
  come area amministrativa.

## Link a codice/docs

- [Architettura](architecture.md)
- [Policy base](../app/Models/Policies/MediaBasePolicy.php)
- [Policy media](../app/Models/Policies/MediaPolicy.php)
- [Schema allegati](../app/Actions/GetAttachmentsSchemaAction.php)
- [Salvataggio allegati](../app/Actions/SaveAttachmentsAction.php)
- [Impostazioni](../app/Filament/Pages/SettingPage.php)
