# Documentazione API con Swagger

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

La documentazione delle API tramite Swagger/OpenAPI è attualmente completata al 30%. Questa componente è fondamentale per fornire una documentazione interattiva e aggiornata automaticamente delle API RESTful di il progetto.

## Obiettivi dell'Implementazione

La documentazione API con Swagger/OpenAPI mira a:

1. Fornire una documentazione chiara, completa e interattiva delle API
2. Mantenere la documentazione sincronizzata automaticamente con il codice
3. Facilitare il testing delle API attraverso l'interfaccia web
4. Supportare la generazione di client SDK per diverse piattaforme
5. Standardizzare la descrizione degli endpoint, parametri e risposte

## Componenti Implementati (30%)

- ✅ Installazione e configurazione base di darkaonline/l5-swagger
- ✅ Documentazione di base della struttura API
- ✅ Annotazioni OpenAPI per alcuni endpoint del modulo Patient
- ✅ Generazione automatica documentazione durante il deploy

## Componenti da Implementare (70%)

- 🚧 Completamento annotazioni per tutti gli endpoint API (20%)
- 🚧 Definizione modelli e schemi di risposta (25%)
- 🚧 Configurazione delle risposte di errore standardizzate (15%)
- 🚧 Implementazione esempi di risposta per ciascun endpoint (10%)
- 🚧 Integrazione autenticazione OAuth2 nell'interfaccia Swagger (5%)
- 🚧 Personalizzazione UI della documentazione (5%)
- 📅 Creazione automatica di SDK client
- 📅 Integrazione con sistema CI/CD per verifica API

## Struttura Documentazione

La documentazione API segue la struttura OpenAPI 3.0:

```yaml
openapi: 3.0.0
info:
  title: il progetto API
  description: API per accesso e gestione dati piattaforma il progetto
  version: 1.0.0
servers:
  - url: https://api.<nome progetto>.it/v1
    description: Production server
  - url: https://staging-api.<nome progetto>.it/v1
    description: Staging server
paths:
  /patient/patients:
    get:
      summary: Recupera lista pazienti
      # ...
    post:
      summary: Crea nuovo paziente
      # ...
```

## Implementazione Annotazioni

Le annotazioni sono implementate nel codice dei controller API utilizzando la sintassi phpDoc:

```php
/**
 * @OA\Get(
 *     path="/api/v1/patient/patients",
 *     operationId="getPatientsList",
 *     tags={"Patients"},
 *     summary="Recupera la lista dei pazienti",
 *     description="Restituisce una lista paginata di pazienti",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Numero di pagina",
 *         required=false,
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Elementi per pagina",
 *         required=false,
 *         @OA\Schema(type="integer", default=15)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operazione completata con successo",
 *         @OA\JsonContent(ref="#/components/schemas/PatientCollection")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorizzato",
 *         @OA\JsonContent(ref="#/components/schemas/Error")
 *     )
 * )
 */
```

## Modelli e Schemi

I modelli e gli schemi dati vengono definiti per rappresentare in modo coerente le entità del sistema:

```php
/**
 * @OA\Schema(
 *     schema="Patient",
 *     title="Patient model",
 *     description="Modello del paziente",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="Maria"),
 *     @OA\Property(property="last_name", type="string", example="Rossi"),
 *     @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="fiscal_code", type="string", example="RSSMRA90A01H501U"),
 *     @OA\Property(property="email", type="string", format="email", example="maria.rossi@example.com"),
 *     @OA\Property(property="phone", type="string", example="+39 123 456 7890"),
 *     @OA\Property(property="pregnancy_status", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
```

## UI Documentazione

L'interfaccia di documentazione è accessibile tramite:

- Ambiente di sviluppo: `/api/documentation`
- Ambiente di staging: `https://staging-api.<nome progetto>.it/documentation`
- Produzione: `https://api.<nome progetto>.it/documentation`

La UI consente:
- Esplorazione interattiva degli endpoint
- Testing diretto con parametri
- Autenticazione tramite token
- Visualizzazione schemi e modelli
- Download della documentazione in formato JSON/YAML

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Annotazioni controller principali | Maggio 2024 | Alta |
| Definizione modelli completi | Maggio 2024 | Alta |
| Risposte di errore standard | Giugno 2024 | Media |
| Integrazione OAuth2 | Giugno 2024 | Media |
| Personalizzazione UI | Giugno 2024 | Bassa |
| SDK automatici | Luglio 2024 | Bassa |

## Dipendenze Tecniche

```json
{
  "require": {
    "darkaonline/l5-swagger": "^8.3",
    "zircote/swagger-php": "^4.5"
  }
}
```

## Configurazione Base

```php
// config/l5-swagger.php
'defaults' => [
    'routes' => [
        'api' => 'api/documentation',
    ],
    'paths' => [
        'docs' => storage_path('api-docs'),
        'annotations' => base_path('app'),
        'models' => base_path('app/Models'),
    ],
]
```

## Risorse Assegnate

- 1 Backend Developer (30% tempo)
- 1 Technical Writer (50% tempo)

## Metriche di Successo

- 100% degli endpoint documentati
- Completezza informazioni per ogni endpoint > 90%
- Feedback positivo dagli sviluppatori interni e partner
- Riduzione del 60% nelle richieste di supporto per l'utilizzo API

## Riferimenti

- [OpenAPI Specification](https://swagger.io/specification/)
- [Swagger PHP Documentation](https://zircote.github.io/swagger-php/)
- [Laravel L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)
