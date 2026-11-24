# Manuale d'uso per attori

## Scopo

Cms gestisce pagine, contenuti, sezioni, menu e moduli tramite modelli e risorse Filament, con blocchi e rendering front office. Le policy distinguono il bypass dei ruoli di modulo dai permessi granulari.

## Attori e capacita'

| Attore | Capacita' verificata | Verifica |
|---|---|---|
| Ospite | Puo' raggiungere una pagina front office solo quando la pagina/configurazione non impone middleware di autenticazione; capacita' amministrative N/A verificato. | [PageManagementBusinessLogicTest](../tests/Feature/PageManagementBusinessLogicTest.php#L248-L258); [README](README.md). |
| Utente normale autenticato | Puo' operare sulle risorse solo con il relativo permesso (`page.*`, `page_content.*`, `section.*`, `menu.*`, `module.*`). | [PagePolicy](../app/Models/Policies/PagePolicy.php#L15-L65) e policy analoghe. |
| Utente in gruppo/ruolo | I permessi assegnati al ruolo determinano le azioni; il solo ruolo non bypassa le policy, salvo `cms::admin` o `super-admin`. | [CmsBasePolicy](../app/Models/Policies/CmsBasePolicy.php#L14-L25). |
| Admin | Il ruolo `cms::admin` ha bypass verificato su tutte le policy Cms che estendono `CmsBasePolicy`; un ruolo generico `admin` e' N/A verificato. | [CmsBasePolicy](../app/Models/Policies/CmsBasePolicy.php#L14-L25). |
| Super-admin | Bypass verificato su tutte le policy Cms che estendono `CmsBasePolicy`. | [CmsBasePolicy](../app/Models/Policies/CmsBasePolicy.php#L14-L25). |
| Operatore/moderatore | N/A verificato, salvo permessi granulari o ruolo `cms::admin` esplicitamente assegnati. | Nessun ruolo speciale Cms trovato. |

## Flussi principali

1. Un editor autorizzato apre una risorsa Cms nel pannello Filament.
2. La policy verifica `viewAny`, `view`, `create`, `update`, `delete`, `restore` o `forceDelete` per la risorsa interessata.
3. La pagina e' composta con blocchi/contenuti e puo' essere pubblicata per il rendering front office.
4. Il front office risolve la pagina e applica i middleware dichiarati dalla configurazione della pagina.

## Prerequisiti

- Modulo Cms e relative risorse/modelli disponibili.
- Utente autenticato con `cms::admin`, `super-admin` oppure permesso granulare appropriato per l'azione.
- Per una pagina pubblica: contenuto risolvibile e middleware coerente con il pubblico previsto.

## Limiti e casi non supportati

- Il ruolo generico `admin` non e' un bypass verificato.
- Un ospite non puo' essere considerato editor Cms; l'accesso front office dipende dai middleware della singola pagina.
- Un operatore/moderatore non ha capacita' Cms implicite.
- Il bypass vale per le policy che estendono `CmsBasePolicy`; non va esteso a classi non verificate.

## Riferimenti owner

- [README](README.md)
- [CmsBasePolicy](../app/Models/Policies/CmsBasePolicy.php)
- [PagePolicy](../app/Models/Policies/PagePolicy.php)
- [PageContentPolicy](../app/Models/Policies/PageContentPolicy.php)
- [SectionPolicy](../app/Models/Policies/SectionPolicy.php)
- [MenuPolicy](../app/Models/Policies/MenuPolicy.php)
- [ModulePolicy](../app/Models/Policies/ModulePolicy.php)
- [test gestione pagine](../tests/Feature/PageManagementBusinessLogicTest.php)
- [test policy](../tests/Unit/Models/Policies/PoliciesTest.php)
