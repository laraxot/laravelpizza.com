https://martinjoo.dev/how-to-use-data-transfer-objects-and-actions-in-laravel




//---- collezioni a mano 
https://blog.programster.org/php-creating-strict-type-arrays      !!!!!!!!!!!!!


https://phpstan.org/r/813cc9a7-19d7-4127-ac1e-8275d38647d2



https://stitcher.io/blog/generics-in-php-1   !!

class Collection<Type> extends ArrayObject
{
    public function offsetGet(mixed $key): Type 
    { /* … */ }
    
    // …
}

