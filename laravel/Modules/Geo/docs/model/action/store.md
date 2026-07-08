---
title: Store Action
description: Store Model with Queuable Action
extends: _layouts.documentation
section: content
---
# Store Action {#store}

This is Store quauable action

Action File Path:

```php
laravel/Modules/Xot/Actions/Model/StoreAction.php
```

## What it does:

It takes three params:

* the **model** calling the store action
* the **data** array to store
*  the **rules** needed to validate data

```php
public function execute(Model $row, array $data, array $rules): Model {
```

* If there is a fillable field named *lang*;
* If *lang* is not set in data;
* Then data get *lang* from the website Locale configuration.

```php
if (! isset($data['lang']) && \in_array('lang',  $row->getFillable(), false)) {
    $data['lang'] = app()->getLocale();
}
```

* If *user_id* is not set in data
* If *user_id* field is fillable in this table
* if *user_id* is not the Primary Key of this model
* Then data get user_id from the current authenticated user

```php
if (! isset($data['user_id'])
    && \in_array('user_id',  $row->getFillable(), false)
    && 'user_id' !== $row->getKeyName()
    ) {
    data['user_id'] = \Auth::id();
}
```

Data is validated with **rules** or throws a Validation error

```php
$validator = Validator::make($data, $rules);
$validator->validate();
```

* The model passed is filled with validated data
* **Fill** fills the model with an array of attributes.

```php
$row = $row->fill($data);
$row->save();
```

Checks if some data attributes belongs to any model relation

```php
$relations = app(FilterRelationsAction::class)->execute($row, array_keys($data));
```

If some attributes belong to relations, then it pass them to the related queuable action to store.

```php
foreach ($relations as $relation) {
    $act = __NAMESPACE__.'\\Store\\'.$relation->relationship_type.'Action';
    $relation->data = $data[$relation->name];
    app($act)->execute($row, $relation);
}
```

Send session flash messages to confirm that the model was created, and returns this model itself.

```php
$msg = 'created! ['.$row->getKey().']!';

Session::flash('status', $msg); // .

return $row;
```