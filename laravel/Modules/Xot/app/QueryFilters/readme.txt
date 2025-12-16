https://medium.com/swlh/laravel-the-hidden-pipeline-part-1-a4ae91fc55a4
https://freek.dev/833-understanding-laravel-pipelines



$result = app(\Illuminate\Pipeline\Pipeline::class)
    ->send(’this should be correctly formatted’)
    ->through([
        // ...
        'App\Strings\Pipes\RemoveWords:should,formatted'
     ])->thenReturn();
echo $result; // "this be correctly"


//----------------------


/**
 * Removes a list of words
 *
 * @param string $string
 * @param Closure $next
 * @param array $remove
 * @return string
 */
public function handle($string, Closure $next, ...$remove)
{
    return $next(str_replace($remove, '', $string));
}

--------------------------------------------------------------------------
        $article->body = $pipeline->send($request->body)
            ->through([
                Paragraphize::class,
                RemoveDuplicates::class,
                AddPunctutation::class,
                EncodeToHtml::class,
            ])->thenReturn();

        $article->save();
-----------------------------------------------------------------------
$result = app(\Illuminate\Pipeline\Pipeline::class)
    ->send(’this should be correctly formatted’)
    ->through(
        function ($passable, $next) {
          return $next(ucfirst($passable));
        },
        AddPunctuation::class,
        new RemoveDoubleSpacing(),
        InvokableClassToRemoveDuplicatedWords::class
     );
--------------------------------------------------------------------------
