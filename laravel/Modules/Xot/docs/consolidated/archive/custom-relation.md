---
title: Custom Relation
description: Custom Relation
extends: _layouts.documentation
section: content
---
# Come funzionano le custom relations? {#custom-relation}

Vediamo prima come funziona con le relazioni standard di laravel.

### Dobbiamo mettere in relazione i modelli Contract > HabitantContract > Habitant > Person

* Contract ha relazione ManyToMany con Habitant, passando per la Pivot HabitantContract.

* Habitant ha relazione HasOne con Person.

### Quello che voglio è:

* Vedere tutte le persone nel sistema

* Vedere per ogni persona la colonna con l'array degli eventuali contratti attivi.

Potremmo utilizzare la relazione HasManyTrought, ma siamo a 4 livelli di profondità, quindi non si può.

Potremmo fare un ciclo per ogni persona e leggere i contract, ma sarebbe lento.

### L'alternativa migliore è fare le Relazioni Customizzate!

Vediamo come:

Nel modello person creiamo la relazione, come tutte le altre, ma con il nome della relazione personalizzata:

```php
class Person extends Model
{
//ritorna una relazione come tutte le altre
    public function activeContracts(): ActiveContractsRelation
    {
        return new ActiveContractsRelation($this);
    }
}
```

ActiveContractsRelation sarà quindi il nome della relazione personalizzata
che leggerà i contratti attivi per ogni persona passando per Habitant.

In Laravel esiste una relazione di base che viene utilzzata da tutte le altre relazioni, 
che è **Illuminate\Database\Eloquent\Relations\Relation**

Quindi andiamo a vedere com'è fatta ed estendiamo la classe:


```php
class ActiveContractsRelation extends Relation
{
    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints() { /* … */ }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param array $models
     *
     * @return void
     */
    public function addEagerConstraints(array $models) { /* … */ }

    /**
     * Initialize the relation on a set of models.
     *
     * @param array $models
     * @param string $relation
     *
     * @return array
     */
    public function initRelation(array $models, $relation) { /* … */ }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param array $models
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @param string $relation
     *
     * @return array
     */
    public function match(array $models, Collection $results, $relation) { /* … */ }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults() { /* … */ }
}
```

Inseriamo un costruttore all'interno della classe.

Nel costruttore passiamo il modello Person ($parent - il modello related)

Nella classe parent (Relation) passiamo l'Eloquent Builder o il modello Contract (per leggere i contratti attivi)

Passare Models\Contract oppure Database\Eloquent\Builder serve per facilitare l'auto completamento dell'IDE

```php
    /** @var \App\Domain\Contract\Models\Contract|Illuminate\Database\Eloquent\Builder */
    protected $query;

    /** @var \App\Domain\People\Models\Person */
    protected $parent;

    public function __construct(Person $parent)
    {
	//qui usiamo sia il Builder che il modello Person
//Questo consentirà all’IDE di avere un miglior completamento automatico 
        parent::__construct(Contract::query(), $parent);
    }
```

Quindi in pratica la relazione **interrogherà il modello Contract e utilizzerà il modello Person come genitore**.

### Ora bisogna costruire la query della relazione.

E' qui che entra in gioco il metodo **addConstraint**.
Serve per configurare la query di base. Imposterà la nostra query di relazione in modo specifico per le nostre esigenze. 

Questo è il luogo in cui sarà contenuta la maggior parte delle regole:

- Vogliamo che vengano visualizzati solo i contratti attivi

- Vogliamo caricare solo i contratti attivi che appartengono a una persona specificata (il $parent della nostra relazione)

- Potremmo voler caricare alcune altre relazioni, ma ne parleremo più avanti.

Ecco come sarà per ora il metodo addConstraints:

```php
class ActiveContractsRelation extends Relation
{
    public function addConstraints()
    {
	    //la query è su Contract Builder (query)
        $this->query
            ->whereActive() //dove il contratto ha lo stato Attivo
            ->join(
                'contract_habitants', 
                'contract_habitants.contract_id', 
                '=', 
                'contracts.id'
            ) //dove nella pivot contract_habitants.contract_id=contracts.id
            ->join(
                'habitants', 
                'habitants.id', 
                '=', 
                'contract_habitants.habitant_id'
            ); //dove contract_habitants.habitant_id=habitants.id

    //praticamente è una semplicissima relazione Many To Many da Contract ad Habitant
    }
}
```

A questo punto **invece di fare una query per persona** per caricare i suoi contratti, stiamo facendo una query per **caricare tutti i contratti e collegare questi contratti alle persone corrette** in seguito. Per questo si usa l’**Eager Constraint**.

### Vediamo come creare il metodo addEagerConstraints

Partiamo con il dire che addEagerConstraints ci consente di modificare la query per **pre-caricare tutti i contratti relativi a un insieme di persone**

```php
class ActiveContractsRelation extends Relation
{
    //array people è l’array dell’insieme di persone su cui leggere i contatti attivi
    public function addEagerConstraints(array $people)
    {
        //whereIn significa che cercherà tutti i $people->id in habitants.contact_id
        $this->query->whereIn(
            'habitants.contact_id', 
		    //gli id delle persone sulle quali fare poi le relazioni
            collect($people)->pluck('id')
        );
        //quindi habitants.contact_id dovrà essere uguale all'insieme $people->id
        //e poi verrà concatenata la query in baseConstraints
    }
}
```

### Il metodo initRelation

Il metodo initRelation serve ad iniziare una relazione vuota, prima di riempirla facendo le query sopra.

```php
public function initRelation(array $people, $relation)
    {
        foreach ($people as $person) {
            $person->setRelation(
                $relation, 
			    //crea una relazione vuota sul modello related in questo caso è Contract
                $this->related->newCollection()
            );
        }

        return $people;
    }
```

### Il metodo match

Ora bisogna collegare insieme tutte le persone con i contratti, ed è qui che entra in gioco il metodo match.

```php
public function match(array $people, Collection $contracts, $relation)
    {
        if ($contracts->isEmpty()) {
            return $people;
        }

        foreach ($people as $person) {
            $person->setRelation(
                $relation, 
                $contracts->filter(function (Contract $contract) use ($person) {
                    //i contract di cui habitants->person_id contengono $person->id
                    //verranno aggiunti alla relazione $person->activeContracts()
                    return $contract->habitants->pluck('person_id')->contains($person->id);
                })
            );    
        }

        return $people;
    }
```

Siccome però habitants non c'è nella relazione nel metodo addEagerConstraints, quindi non possiamo sapere i person_id
andiamo ad aggiungerlo, e leggiamo solo i dati dalla tabella Contracts, ignorando i dati delle altre tabelle della query join.

```php
class ActiveContractsRelation extends Relation
{
//array people è l’array dell’insieme di persone 
//su cui caricare i contatti
    public function addEagerConstraints(array $people)
    {
        $this->query->whereIn(
            'habitants.contact_id', 
             collect($people)->pluck('id')
        )->with('habitants')
            //seleziona solo i dati della tabella contracts
            //altrimenti i relativi dati di habitants verranno uniti nel modello Contract
            ->select('contracts.*');
    }
}
```

A questo punto basta fare:

```php
public function getResults()
    {
        return $this->query->get();
    }
```

## Come fare la stessa relazione con CustomRelation?

```php
use Modules\Xot\Traits\HasCustomRelations;
use Modules\ModuleName\Models\Contract;

class Person
{
    use HasCustomRelations;

    /**
     * Get the related permissions
     *
     * @return Illuminate\Database\Eloquent\Relations\Relation
     */
    public function activeContracts()
    {
        return $this->custom(
            Contract::class,

            // add constraints
            function ($relation) {
                $relation->getQuery()
                ->whereActive()
                ->join(
                    'contract_habitants', 
                    'contract_habitants.contract_id', 
                    '=', 
                    'contracts.id'
                ->join(
                    'habitants', 
                    'habitants.id', 
                    '=', 
                    'contract_habitants.habitant_id'
            },

            // add eager constraints
            function ($relation, $models) {
                $relation->getQuery()
                whereIn('habitants.contact_id', $relation->getKeys($models))
            }
        );
    }
}
```