# Confronto tra Implementazioni del Carrello della Spesa

## Introduzione

Spatie ha sviluppato due progetti principali per dimostrare l'uso dell'Event Sourcing in un carrello della spesa. Questo documento confronta i due approcci per evidenziarne i punti di forza e la loro applicabilità al modulo `Activity`.

## Varianti del Carrello della Spesa

### 1. Laravel Shop Main (`/var/www/html/laravel-shop-main/`)

- **Approccio**: Applicazione di riferimento completa.
- **Caratteristiche**:
  - Include un'installazione pulita di Laravel con codice Event Sourcing per un carrello di base.
  - La logica di business è organizzata in `Domain` con aggregate, eventi e azioni.
  - Fornisce controller per interazioni come aggiungere articoli o checkout.
- **Vantaggi**:
  - Facile da usare come punto di partenza per un progetto personalizzato.
  - Include un diagramma temporale (`/docs/timeline.png`) per comprendere il flusso degli eventi.
- **Svantaggi**:
  - Meno strutturato come pacchetto riutilizzabile, più adatto come esempio.
  - Richiede adattamenti significativi per progetti complessi.
- **Rilevanza per Activity**: Utile per apprendere i concetti di base dell'Event Sourcing e prototipare rapidamente.

### 2. Laravel Shop Command Bus (`/var/www/html/laravel-shop-command-bus/`)

- **Approccio**: Pacchetto strutturato con command bus.
- **Caratteristiche**:
  - Implementa un carrello della spesa come pacchetto installabile tramite Composer.
  - Organizza la logica in moduli separati (`Cart`, `Order`, `Payment`, ecc.).
  - Usa un command bus per gestire comandi ed eventi in modo strutturato.
- **Vantaggi**:
  - Più modulare e riutilizzabile in progetti esistenti.
  - Separazione chiara delle entità di business.
- **Svantaggi**:
  - Curva di apprendimento più ripida a causa della struttura complessa.
  - Meno documentazione visiva rispetto a `laravel-shop-main`.
- **Rilevanza per Activity**: Ideale per integrare un carrello della spesa in un'applicazione esistente come il modulo `Activity`.

## Confronto Diretto

| Variante                 | Tipo Progetto         | Strutturazione       | Facilità d'Uso | Riutilizzabilità | Documentazione Visiva |
|--------------------------|-----------------------|----------------------|----------------|------------------|-----------------------|
| Laravel Shop Main        | Applicazione Esempio  | Media                | Alta           | Bassa            | Alta                  |
| Laravel Shop Command Bus | Pacchetto Composer    | Alta                 | Media          | Alta             | Bassa                 |

## Considerazioni per il Modulo Activity

- **Prototipazione**: Usa `Laravel Shop Main` per apprendere i concetti e creare prototipi rapidi di un sistema di ordini.
- **Integrazione**: Scegli `Laravel Shop Command Bus` per integrare un carrello della spesa in un'applicazione esistente, grazie alla sua natura modulare.
- **Personalizzazione**: Entrambi i progetti richiedono personalizzazioni per adattarsi a use case specifici come la gestione di forniture mediche.

## Conclusione

Per il modulo `Activity`, **Laravel Shop Command Bus** è l'approccio più adatto per un'implementazione a lungo termine, grazie alla sua modularità e riutilizzabilità. Tuttavia, **Laravel Shop Main** è prezioso per comprendere i concetti di base dell'Event Sourcing e per prototipi iniziali. Si consiglia di iniziare con l'esempio per l'apprendimento, quindi passare al pacchetto per l'integrazione effettiva.
