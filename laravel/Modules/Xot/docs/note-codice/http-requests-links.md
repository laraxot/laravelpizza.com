https://webdevetc.com/blog/laravel-features-you-may-not-know-about


Use the prepareForValidation() in your Form Requests
If you wish to modify data from a Form Request object before validation, you can use the prepareForValidation() method.

The prepareForValidation() method is called before validation happens, and if your request calls a method such as $this->merge(['some_key'=>'a new value']) then when you later call something like $request->all(), it will contain an item with key 'some_key' and value 'a new value'.

public function prepareForValidation()
{
    $this->merge(
        [
            'name' => $this->get('first_name') . ' ' . $this->get('last_name'),
            'email' => strtolower($this->get('email')),
            'random_position' => rand(0,100),
        ]
    );
}

https://sampo.co.uk/blog/manipulating-request-data-before-performing-validation-in-laravel

