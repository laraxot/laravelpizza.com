# Implementazione di strict_types nel Modulo UI

## Importanza di declare(strict_types=1)

L'utilizzo di `declare(strict_types=1)` è **obbligatorio** in tutti i file PHP del modulo UI che contengono logica di business, in conformità con le [regole generali del progetto](../../Xot/docs/php-strict-types.md) e per garantire la compatibilità con PHPStan livello 10.

### Vantaggi per il Modulo UI

1. **Sicurezza dei tipi nei componenti UI**: Garantisce che i dati passati ai componenti UI siano del tipo corretto, prevenendo errori di rendering.
2. **Prevenzione di errori nei Service Provider**: Assicura che i metodi di registrazione dei componenti ricevano e restituiscano i tipi corretti.
3. **Compatibilità con PHPStan livello 10**: Requisito fondamentale per superare l'analisi statica al livello più alto.
4. **Coerenza con l'architettura modulare**: Mantiene la coerenza con gli altri moduli del sistema.

## Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\UI\YourNamespace;

// Resto del codice
```

## File che Richiedono strict_types nel Modulo UI

- **Providers**: Tutti i Service Provider (`UIServiceProvider.php`, ecc.)
- **Components**: Tutti i componenti Blade personalizzati
- **Helpers**: Funzioni helper specifiche per UI
- **Traits**: Traits utilizzati dai componenti UI
- **Interfaces**: Interfacce per componenti e servizi UI

## Errori Comuni da Evitare

1. **Omissione della dichiarazione**: Non includere `declare(strict_types=1)` nei file PHP
2. **Posizionamento errato**: Inserire la dichiarazione dopo il namespace o altri elementi
3. **Inconsistenza**: Applicare la dichiarazione solo in alcuni file del modulo

## Processo di Verifica

Per verificare che tutti i file PHP del modulo UI abbiano la dichiarazione `strict_types`:

```bash
find Modules/UI -name "*.php" -type f -not -path "*/vendor/*" -exec grep -L "declare(strict_types=1)" {} \;
```

## Risoluzione dei Conflitti Git

Durante la risoluzione dei conflitti Git, è fondamentale assicurarsi che la dichiarazione `declare(strict_types=1)` sia sempre presente e posizionata correttamente nei file PHP, subito dopo il tag di apertura PHP e prima di qualsiasi altro elemento.

## Collegamenti

- [Regole Generali per strict_types](../../Xot/docs/php-strict-types.md)
- [Linee Guida PHPStan Livello 10](../../Xot/docs/PHPStan/LEVEL10_LINEE_GUIDA.md)
- [Conflitti Merge Risolti](./CONFLITTI_MERGE_RISOLTI.md)
- [README del Modulo UI](./README.md)
