# Script PHP di Utilità

Questa directory contiene script PHP di utilità per il progetto.

## Script Disponibili

### add_strict_types.php

Questo script aggiunge automaticamente la dichiarazione `declare(strict_types=1);` a tutti i file PHP del progetto che non la contengono già.

#### Utilizzo
```bash
php add_strict_types.php
```

#### Funzionalità
- Cerca ricorsivamente tutti i file PHP nel progetto
- Aggiunge `declare(strict_types=1);` dopo il tag `<?php` se non è già presente
- Esclude automaticamente le directory:
  - vendor
  - node_modules
  - storage
  - bootstrap/cache

#### Best Practices
- Eseguire questo script dopo aver aggiunto nuovi file PHP
- Mantenere `declare(strict_types=1);` in tutti i file PHP del progetto
- Non modificare manualmente i file nella directory vendor

## Regole Generali per gli Script PHP

1. Tutti gli script PHP devono:
   - Iniziare con `declare(strict_types=1);`
   - Seguire le PSR-12 coding standards
   - Includere commenti appropriati
   - Essere collocati in questa directory

2. Struttura delle Directory:
   - `/bashscripts/utils/php/` - Script PHP di utilità
   - `/bashscripts/utils/php/tests/` - Test per gli script
   - `/bashscripts/utils/php/docs/` - Documentazione aggiuntiva

3. Convenzioni di Denominazione:
   - Nomi file: snake_case.php
   - Nomi classi: PascalCase
   - Nomi funzioni: camelCase

4. Documentazione:
   - Ogni script deve avere un commento di intestazione che ne descrive lo scopo
   - Includere esempi di utilizzo nel README
   - Documentare eventuali dipendenze 