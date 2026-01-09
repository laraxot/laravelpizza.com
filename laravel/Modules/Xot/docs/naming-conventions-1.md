# Convenzioni di Nomenclatura in Laravel Modules

Questo documento definisce le convenzioni ufficiali di nomenclatura da utilizzare in tutto il progetto Laravel Modules.

## Panoramica
Questo documento descrive le convenzioni di denominazione da seguire all'interno di un modulo Laravel per garantire coerenza e chiarezza nel codice.

## Principi chiave
1. **Denominazione descrittiva**: Utilizzare nomi descrittivi che indichino chiaramente lo scopo o il comportamento delle variabili, metodi e classi.
2. **Coerenza**: Mantenere schemi di denominazione coerenti in tutto il codice per ridurre il carico cognitivo.

## Linee guida per l'implementazione
### 1. Denominazione delle classi
- Utilizzare PascalCase per i nomi delle classi, assicurandosi che siano sostantivi che descrivono l'entità o la funzionalità.
  ```php
  class UserProfile
  {
      // Definizione della classe
  }
  ```

### 2. Denominazione dei metodi
- Utilizzare camelCase per i nomi dei metodi, iniziando con un verbo che descrive l'azione eseguita.
  ```php
  public function calculateTotalPrice()
  {
      // Implementazione del metodo
  }
  ```

### 3. Denominazione delle variabili
- Utilizzare camelCase per i nomi delle variabili, rendendole descrittive dei dati che contengono.
  ```php
  $userFullName = 'John Doe';
  ```

### 4. Denominazione dei file
- Fare in modo che i nomi dei file corrispondano ai nomi delle classi per le classi, utilizzando PascalCase. Per altri file, utilizzare kebab-case per descrivere il contenuto.
  ```
  UserProfile.php
  user-profile-utils.php
  ```

## Problemi comuni e soluzioni
- **Denominazione incoerente**: Evitare di mescolare stili di denominazione (ad esempio, snake_case con camelCase) per mantenere la leggibilità.
- **Nomi vaghi**: Rinominare nomi vaghi come `$data` o `$temp` in qualcosa di più descrittivo come `$userData` o `$temporaryResult`.

## Documentazione e aggiornamenti
- Documentare eventuali deviazioni da queste convenzioni di denominazione nella cartella di documentazione del modulo pertinente.
- Aggiornare questo documento se vengono introdotti nuovi schemi di denominazione o convenzioni.

## Collegamenti alla documentazione correlata
- [Qualità del codice](./CODE_QUALITY.md)
- [Tipi rigorosi PHP](./PHP-STRICT-TYPES.md)
- [Guida all'implementazione di PHPStan](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Best practice per i provider di servizi](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Best practice per Filament](./FILAMENT-BEST-PRACTICES.md)
