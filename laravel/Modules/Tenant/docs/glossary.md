---
title: "Glossario di dominio Tenant"
type: glossary
owner: Tenant
updated: 2026-11-24
qmd: "glossario Tenant nome tenant config overlay dominio Sushi contenuto JSON morph map"
---

# Glossario di dominio Tenant

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/Tenant/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Tenant | Entità che identifica il contesto tenant (modello Eloquent). | `app/Models/Tenant.php` |
| Nome tenant | Percorso sotto `config/` ricavato dall'host con dominio invertito e slugato (es. `local/ptvx`) o `localhost`. | `app/Actions/GetTenantNameAction.php` |
| Config del tenant | File PHP in `config/<nome tenant>/` che sovrascrivono i default Laravel. | `app/Actions/Config/GetTenantFilePathAction.php` |
| Overlay | Config base Laravel con sopra `array_replace_recursive` l'override del tenant. | `app/Actions/Config/ResolveTenantConfigValueAction.php` |
| Percorso file tenant | Percorso assoluto di un file del tenant; rifiuta assoluti, NUL e `..`. | `GetTenantFilePathAction::execute` |
| Salvataggio config | Fusione e scrittura del file di config; le liste sostituiscono, le mappe si fondono. | `app/Actions/Config/SaveTenantConfigAction.php` |
| Contenuto JSON del sito | Pagine, sezioni e menu versionati in `config/<tenant>/database/content/`. | `GetTenantFilePathAction.php:102` |
| Sushi su JSON | Trait che serve un modello Eloquent da file JSON del tenant. | `app/Models/Traits/SushiToJsons.php`, `app/Models/Traits/SushiToJson.php` |
| Morph map del tenant | Mappa nome-classe risolta dalla config `morph_map.<nome>`, per tenant. | `app/Actions/Models/ResolveTenantModelClassAction.php` |
| Moduli del tenant | Elenco dei moduli attivi letto da `modules_statuses.json` del tenant. | `app/Actions/Modules/GetTenantModulesAction.php` |
| Dominio | Hostname di un tenant con flag principale, stato e token di verifica. | `app/Models/Domain.php`, `app/Models/TenantDomain.php` |
| Impostazione tenant | Coppia chiave/valore con tipo legata a un `tenant_id`. | `app/Models/TenantSetting.php` |
| Abbonamento | Piano, limiti e dati di fatturazione del tenant (`tenant_subscriptions`). | `app/Models/TenantSubscription.php` |
| Config database | Modello della configurazione di connessione database. | `app/Models/DatabaseConfig.php` |
| Dati ente | DTO con i recapiti dell'ente (link `tel:`/`mailto:`). | `app/Datas/EnteData.php` |
