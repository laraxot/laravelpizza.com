# Model Has Roles Migration Documentation

## Overview
La migrazione `2024_12_05_000034_create_model_has_roles_table.php` crea la tabella pivot per la relazione polimorfica tra modelli e ruoli nel sistema di autorizzazione.

## Struttura

### Colonne Principali
- `id`: Chiave primaria auto-incrementante
- `role_id`: Chiave esterna per il ruolo (integer, nullable)
- `model_type`: Tipo del modello polimorfico
- `model_id`: ID del modello polimorfico
- `team_id`: Chiave esterna per il team (nullable)

### Indici
- Indice su `role_id`
- Indice su `model_id`
- Indice su `team_id`

### Relazioni
- Relazione polimorfica con i modelli
- Relazione con i ruoli
- Relazione opzionale con i team

## Utilizzo
```php
// Esempio di assegnazione ruolo
$user->roles()->attach($roleId);

// Esempio di verifica ruolo
$user->hasRole($roleName);
```

## Best Practices
- Utilizzare UUID per gli ID dei modelli
- Gestire correttamente i team per il multi-tenant
- Implementare controlli di autorizzazione appropriati

## Recent Changes
- Rimossi conflitti di merge
- Migliorata la gestione dei tipi di ID
- Aggiunto supporto per UUID
- Ottimizzata la struttura degli indici 