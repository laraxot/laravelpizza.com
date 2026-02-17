# Analisi metodi duplicati in HasTeams (trait)

## Introduzione
Nel trait `HasTeams` sono presenti diversi metodi con lo stesso nome ma implementazioni differenti. Questo documento elenca i metodi in ordine alfabetico, individua i duplicati e fornisce criteri oggettivi per decidere quale versione mantenere in fase di refactor.

## Elenco metodi (in ordine alfabetico)

- allTeams()
- belongsToTeam()
- belongsToTeams()
- canAddTeamMember()
- canCreateTeam()
- canDeleteTeam()
- canLeaveTeam()
- canManageTeam()
- canRemoveTeamMember()
- canUpdateTeam()
- canUpdateTeamMember()
- canViewTeam()
- currentTeam()
- demoteFromAdmin()
- getTeamAdmins()
- getTeamMembers()
- hasTeamPermission()
- hasTeamRole()
- hasTeams()
- inviteToTeam()
- isCurrentTeam()
- isOwnerOrMember()
- ownedTeams()
- personalTeam()
- promoteToAdmin()
- removeFromTeam()
- switchTeam()
- teamPermissions()
- teamRole()
- teams()

## Metodi duplicati rilevati

- allTeams()
- belongsToTeam()
- currentTeam()
- hasTeamPermission()
- hasTeamRole()
- ownedTeams()
- personalTeam()
- switchTeam()
- teamPermissions()
- teamRole()

## Criteri per la scelta della versione da mantenere

1. **Tipizzazione e parametri**: preferire la versione con type hinting più rigoroso e parametri nullable solo se necessario.
2. **Compatibilità con interfacce/contratti**: mantenere la versione che rispetta i contratti definiti nei moduli (es. TeamContract, UserContract).
3. **Aderenza alle convenzioni di progetto**: preferire la versione che segue le convenzioni di naming, return type, e uso dei trait.
4. **Presenza di controlli e validazioni**: mantenere la versione che effettua più controlli (es. null, instanceof, assert).
5. **Uso di dipendenze e helper**: preferire la versione che utilizza helper centralizzati (es. XotData) e riduce la duplicazione di logica.
6. **Chiarezza e manutenibilità**: mantenere la versione più leggibile, documentata e facilmente estendibile.
7. **Compatibilità con Eloquent/Laravel**: preferire la versione che sfrutta al meglio le relazioni Eloquent e le feature Laravel.

## Esempio di confronto (belongsToTeam)
- Versione 1: usa teams()->get()->first(...)
- Versione 2: usa $this->teams->contains(...)
- **Criterio**: preferire la versione che funziona sia con relazioni caricate che lazy, e che gestisce meglio i casi edge/null.

## Checklist per refactor futuro
- [ ] Individuare tutti i duplicati e confrontare le firme
- [ ] Applicare i criteri sopra per ogni coppia
- [ ] Mantenere solo la versione migliore e rimuovere l'altra
- [ ] Aggiornare i test e la documentazione
- [ ] Verificare la compatibilità con i moduli che usano il trait

## Collegamenti correlati
- [Indice documentazione User](./INDEX.md)
- [Modello User](./Models/User.md)
- [Best practices trait](./best-practices-traits.md)
- [Refactor checklist](./refactor-checklist.md)
- [XotData helper](../../Xot/docs/standards/README.md)

---

> Questo documento va aggiornato ogni volta che si interviene sul trait HasTeams o si modificano le convenzioni di progetto relative ai trait e alle relazioni tra modelli. 

## Nota architetturale: TeamContract vs Team

Quando si implementano trait come HasTeams, è fondamentale tipizzare e accettare sempre `TeamContract` invece di `Team` nei metodi e nelle relazioni. Questo garantisce:
- compatibilità con implementazioni custom di team
- facilità di test tramite mock/stub
- manutenibilità e flessibilità futura

Per la motivazione dettagliata, vedi la sezione dedicata in [Team.md](./Models/Team.md#motivazione-preferire-teamcontract-a-team-nei-trait-e-nei-metodi). 
