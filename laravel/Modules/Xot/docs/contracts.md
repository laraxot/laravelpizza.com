
//--- Illuminate\Database\Eloquent\Relations\relation (abstract class Relation)
->getRelated()

//--- Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable (trait InteractsWithPivotTable) - BelongsToMany
->detach()
->attach()


//---- Illuminate\Database\Eloquent\Concerns\QueriesRelationships (trait QueriesRelationships)
public function whereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)

//---- Illuminate\Database\Eloquent\Builder  (class Builder)
 public function getModel()