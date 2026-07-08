---
title: ModelService
description: Handle models with ModelService
extends: _layouts.documentation
section: content
---

# ModelService

### Returns the instance of the class

```php
public static function make(): self
```

Example

```php
ModelService::make();
```

### Set the property *model* from the *model instance*

```php
public function setModel(Model $model): self {
```

Example

```php
$row=User::get()->first();
ModelService::make()->setModel($row): self {
```

### Set the property *model* from the *class name with namespace*

```php
public function setModelClass(string $class): self {
```

Example

```php
ModelService::make()->setModelClass(\Modules\Xot\Datas\XotData::make()->getUserClass()): self {
```

### Uses the model property and search the passed **$data** in its *relationships*

```php
public function getRelationshipsAndData(array $data): array
```

Example

```php
/*
Profile table
$table->bigIncrements('id');
$table->string('location')->nullable();
$table->integer('user_id')->nullable();
*/

/*
User table
$table->bigIncrements('id');
$table->string('first_name')->nullable();
$table->string('email')->nullable();
*/

/*
Profile model
public function user(): BelongsTo {
    return $this->belongsTo(\Modules\Xot\Datas\XotData::make()->getUserClass());
}
*/

$profile=Profile::get()->first();
ModelService::make()->setModel($profile)->getRelationshipsAndData(['first_name'=>'Davide','email'=>'davide@davide.xx','location'=>'Venezia']);
```

Get class methods inside *model* property

```php
$methods = get_class_methods($model);
```

Filter *methods data* instead of simple properties data

```php
$data = collect($data)->filter(
function ($item, $key) use ($methods) {
    return \in_array($key,  $methods, false);
})
```

* If the array key is not a strings returns error
* Set $rows as the model relation to $k (the key)
* Initialize $related to null
* If $rows has the method getRelated, sets $related to the *model of its relationship*

* **Returns the:**
+ relationship type (BelongsTo, HasMany, ManyToMany, ecc..)
+ relation instance
+ related model
+ related attributes
+ name of the relation (user, profile, relatedModelName, ecc) 
+ relationship itself

```php
)->map(
    function ($v, $k) use ($model, $data) {
        if (! \is_string($k)) {
            dddx([$k, $v, $data]);
        }
        
        $rows = $model->$k();
        $related = null;
        if (\is_object($rows) && method_exists($rows, 'getRelated')) {
            $related = $rows->getRelated();
        }

        return (object) [
            'relationship_type' => class_basename($rows),
            'is_relation' => $rows instanceof \Illuminate\Database\Eloquent\Relations\Relation,
            'related' => $related,
            'data' => $v,
            'name' => $k,
            'rows' => $rows,
        ];
    })
```

### Returns the class associated with its name (morphmapped)

```php
public function getPostType(): string {
```

Example

```php
$profile=PressPost::get()->first();
ModelService::make()->setModel($profile)->getPostType();
```

Reads *morph_map* value from the morph_map.php configuration, inside every domain

```php
$models = config('morph_map');

/* 
Example

return [
    'model1' => 'Modules\ModuleName\Models\Model1',
    'model2' => 'Modules\ModuleName\Models\Model2',
    'model3' => ''Modules\ModuleName\Models\Model3',
];
*/
```

Serch the name of the $model class inside morph_map.php array (in this case is PressPost)

```php
$post_type = collect($models)->search(\get_class($model));
```

If it doesn't fine anything it sets $post_type to the **snake case name** of the setted $this->model (PressPost)

```php
if (false === $post_type) {
    $post_type = snake_case(class_basename($model));

/*  
$post_type='press_post'*/
```

Set the morph map for polymorphic relation, and return an array

```php
    Relation::morphMap([$post_type => \get_class($model)]);
    /* Return
    ['press_post' => 'Modules\ModuleName\Models\PressPost']
    */
}
```

Set the morph map for polymorphic relation, and return an array

```php
    Relation::morphMap([$post_type => \get_class($model)]);
    /* Return
    ['press_post' => 'Modules\ModuleName\Models\PressPost']
    */
}
```

Returns the previous name => class association

```php
return (string) $post_type;
```

### Get relation names from *model* property

```php
public function getRelations(): array {
```

Example

```php
$profile=PressPost::get()->first();
ModelService::make()->setModel($profile)->getRelations();
```

* The reflection class is used to get information about the current state of the application. 
* It's called reflection, because it looks at itself, and can tell you information about the program your running, at runtime.

```php
$reflector = new ReflectionClass($model);
```

Get the methods from the reflected $model class

```php
$methods = $reflector->getMethods();
```

Get the doc comment if it exists, otherwise false

```php
foreach ($methods as $method) {
    $doc = $method->getDocComment();
```

Get the method name (inside foreach)

```php
    $res = $method->getName();
```  
* If the number of required parameters for this methos are Zero
* If the class of this method is $model
* If the method's $doc isn't false and strpos has the substring *\\Relations\\*

* Then the array $relations adds the method name ($method->getName())

```php
if (0 === $method->getNumberOfRequiredParameters() && $method->class === \get_class($model)) {
        if ($doc && false !== strpos($doc, '\\Relations\\')) {
        $relations[] = $res;
    }
}

return $relations;
``` 

### Get relationships from *model*

```php
public function getRelationships(): array {
```

Example


```php
$profile=PressPost::get()->first();
ModelService::make()->setModel($profile)->getRelationships();
```

* Gets the reflection class from $model
* Gets the public methods from reflection class, and iterates on themù


* If the current function name (getRelationships) is equal to the method name
* OR If the method has more then 0 parameters
* OR if the method class name is different then model class name
* Then the cycle stops and continue the next iteration

```php
$model = $this->model;
$relationships = [];

foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
    if ($method->class !== \get_class($model)
    || ! empty($method->getParameters())
    || __FUNCTION__ === $method->getName()
    ) {
        continue;
    }
```