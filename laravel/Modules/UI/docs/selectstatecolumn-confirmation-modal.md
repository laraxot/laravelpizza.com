# SelectStateColumn - Aggiunta Modal di Conferma

## Panoramica
Questo documento descrive l'implementazione di una modale di conferma con textarea per il componente `SelectStateColumn`. La modale richiederà all'utente di confermare la transizione di stato e fornire un messaggio opzionale.

## Requisiti
- Aggiungere una modale di conferma prima della transizione di stato
- Includere una textarea per inserire un messaggio
- Passare il messaggio al metodo `transitionTo`
- Mantenere la compatibilità con il funzionamento esistente

## Specifiche Tecniche

### Flusso Utente
1. L'utente seleziona un nuovo stato dal menu a discesa
2. Viene visualizzata una modale di conferma con una textarea
3. L'utente può inserire un messaggio opzionale
4. Alla conferma, viene eseguita la transizione con il messaggio
5. In caso di annullamento, la transizione viene interrotta

### Dati
- Il messaggio della textarea deve essere passato come secondo parametro a `transitionTo`
- La modale deve essere chiusa correttamente in entrambi i casi (conferma/annulla)
- Lo stato del form deve essere resettato dopo la chiusura

### Integrazione con Filament
- Utilizzare i componenti modale di Filament
- Implementare la logica di conferma nel metodo `beforeStateUpdated`
- Gestire lo stato della modale con Livewire

## Considerazioni sulla Sicurezza
- Validare l'input della textarea
- Implementare il rate limiting per evitare abusi
- Verificare i permessi dell'utente prima di consentire la transizione

## Documentazione Correlata
- [SelectStateColumn.md](./SelectStateColumn.md)
- [Filament Modals Documentation](https://filamentphp.com/docs/3.x/panels/modals)
- [State Management](./state-management.md)

## Note di Implementazione
- La modale dovrebbe essere disabilitabile tramite configurazione
- Considerare l'aggiunta di un hook per la validazione personalizzata
- Documentare il formato del messaggio atteso dalle transizioni

## Test
Verificare che:
1. La modale venga visualizzata correttamente
2. Il messaggio venga passato correttamente alla transizione
3. La modale si chiuda in entrambi gli scenari
4. Lo stato venga aggiornato correttamente nel database
5. Gli errori vengano gestiti in modo appropriato
# SelectStateColumn - Aggiunta Modal di Conferma

## Panoramica
Questo documento descrive l'implementazione di una modale di conferma con textarea per il componente `SelectStateColumn`. La modale richiederà all'utente di confermare la transizione di stato e fornire un messaggio opzionale.

## Requisiti
- Aggiungere una modale di conferma prima della transizione di stato
- Includere una textarea per inserire un messaggio
- Passare il messaggio al metodo `transitionTo`
- Mantenere la compatibilità con il funzionamento esistente

## Specifiche Tecniche

### Flusso Utente
1. L'utente seleziona un nuovo stato dal menu a discesa
2. Viene visualizzata una modale di conferma con una textarea
3. L'utente può inserire un messaggio opzionale
4. Alla conferma, viene eseguita la transizione con il messaggio
5. In caso di annullamento, la transizione viene interrotta

### Dati
- Il messaggio della textarea deve essere passato come secondo parametro a `transitionTo`
- La modale deve essere chiusa correttamente in entrambi i casi (conferma/annulla)
- Lo stato del form deve essere resettato dopo la chiusura

### Integrazione con Filament
- Utilizzare i componenti modale di Filament
- Implementare la logica di conferma nel metodo `beforeStateUpdated`
- Gestire lo stato della modale con Livewire

## Considerazioni sulla Sicurezza
- Validare l'input della textarea
- Implementare il rate limiting per evitare abusi
- Verificare i permessi dell'utente prima di consentire la transizione

## Documentazione Correlata
- [SelectStateColumn.md](./SelectStateColumn.md)
- [Filament Modals Documentation](https://filamentphp.com/project_docs/3.x/panels/modals)
- [Filament Modals Documentation](https://filamentphp.com/project_docs/3.x/panels/modals)
- [Filament Modals Documentation](https://filamentphp.com/project_docs/3.x/panels/modals)
- [State Management](./state-management.md)

## Note di Implementazione
- La modale dovrebbe essere disabilitabile tramite configurazione
- Considerare l'aggiunta di un hook per la validazione personalizzata
- Documentare il formato del messaggio atteso dalle transizioni

## Test
Verificare che:
1. La modale venga visualizzata correttamente
2. Il messaggio venga passato correttamente alla transizione
3. La modale si chiuda in entrambi gli scenari
4. Lo stato venga aggiornato correttamente nel database
5. Gli errori vengano gestiti in modo appropriato
