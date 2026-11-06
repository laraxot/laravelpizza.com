---
title: "SettingPage funzionali per ogni modulo"
status: in-progress
type: story
module: Xot
---

# Obiettivo

Ogni modulo espone una pagina Filament SettingPage con impostazioni realmente utili al
modulo, tipizzate dalla propria ConfigData e persistite nel file del tenant. Una pagina
vuota non è un completamento: nasconde decisioni operative e rende impossibile amministrare
un tenant senza modificare il codice.

## Contratto

- getFormSchema() non restituisce mai [].
- Ogni chiave del form è una proprietà pubblica della *ConfigData.
- I default sono quelli già presenti nel codice o nella configurazione del modulo.
- I segreti restano in environment/EnvWidget e non vengono copiati nei file tenant.
- Il salvataggio usa BaseSettingPage, SaveTenantConfigAction e la configurazione tenant
  già prevista; non vengono introdotte migrazioni.
- CMS/Xot gestiscono xra.php, inclusa la scelta di pub_theme, adm_theme e lingua.

## Matrice di completamento

| Modulo | Impostazioni minime | Stato |
|---|---|---|
| AI | modello, chat model, temperatura, token, logging | da completare |
| Activity | abilitazione, retention log | implementato |
| Cms | tema pubblico/admin, lingua, middleware consentiti | da completare |
| Gdpr | abilitazione, durata consenso, policy path | da completare |
| Job | abilitazione, tentativi, timeout | implementato |
| Lang | lingua predefinita, lingue supportate | implementato |
| Media | dimensione e MIME allegati | implementato |
| Notify | abilitazione e logging | implementato |
| Seo | titolo sito, descrizione, indicizzazione | da completare |
| Tenant | routing dominio, lingua predefinita | implementato |
| Trade | paper mode, costi, rischio e kill switch | da completare |
| UI | tema scuro, navigazione compatta | implementato |
| User | registrazione e verifica email | implementato |
| Xot | temi, lingua e SSL | implementato |

## Verifica

1. Test architetturale: nessuna pagina ha schema vuoto e ogni Data ha proprietà.
2. Test di persistenza: stato compilato -> Data -> file tenant.
3. PHPStan livello massimo, Pint, PHPMD e Pest del modulo modificato.
4. Aggiornamento coverage e Second Brain dopo i gate.

## Vincoli esclusi

Non si abilita il trading live, non si memorizzano credenziali exchange e non si espongono
chiavi API nelle SettingPage.
