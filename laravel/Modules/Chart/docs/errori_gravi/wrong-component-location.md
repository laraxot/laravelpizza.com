# Errore: Posizionamento Errato dei Componenti

## Descrizione dell'Errore
Componenti Livewire o altri elementi dell'interfaccia utente posizionati nella directory `app/` invece che nei rispettivi moduli.

## Contesto
Il sistema <nome progetto> segue un'architettura modulare dove ogni modulo è autonomo e contiene tutti i suoi componenti. I componenti non dovrebbero mai essere posizionati nella directory `app/` dell'applicazione principale.

## Cause Comuni
1. Sviluppo rapido senza seguire l'architettura
2. Confusione tra applicazione principale e moduli
3. Mancata comprensione della struttura modulare
4. Copia e incolla da altri progetti

## Impatto
- Violazione dell'architettura modulare
- Difficoltà nella manutenzione
- Confusione per gli sviluppatori
- Potenziali conflitti di namespace
- Degrado della qualità del codice

## Soluzione
1. Identificare il modulo corretto per il componente
2. Spostare il componente nella directory appropriata del modulo
3. Aggiornare i namespace e gli import
4. Verificare i riferimenti al componente
5. Aggiornare la documentazione

## Best Practices
1. Seguire sempre la struttura modulare
2. Mantenere i componenti nei loro moduli di appartenenza
3. Documentare la posizione corretta dei componenti
4. Implementare controlli automatici per il posizionamento

## Collegamenti Correlati
- [Architettura del Sistema](../ARCHITETTURA_SISTEMA.md)
- [Struttura Moduli](../STRUTTURA_MODULI_NAMESPACE.md)
- [Standard di Codice](../standards/coding-standards.md)
- [Component Structure Guidelines](../standards/component-structure.md)

## Esempio di Correzione
```php
// ❌ Errore: Componente nella directory app/
// /app/Livewire/Patient/Book.php

// ✅ Corretto: Componente nel modulo Patient
// /laravel/Modules/Patient/app/Livewire/Book.php
```

## Checklist di Verifica
- [ ] Identificato il modulo corretto
- [ ] Spostato il componente nella directory appropriata
- [ ] Aggiornati i namespace
- [ ] Verificati i riferimenti
- [ ] Aggiornata la documentazione
- [ ] Testato il componente nella nuova posizione
- [ ] Verificata la compatibilità con altri componenti 