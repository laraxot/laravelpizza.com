# filters

<!-- Contenuto migrato da _docs/filters.txt -->

<?php
//https://itnext.io/how-i-designed-and-built-lumenos-recruitment-search-engine-d8918b3500
namespace App\Search\Filters;
use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;
class MemberFilter implements Clause
{
    /**
     * Exclude members of the vacancy's organization.
     *
     */
    public static function execute($vacancy, $query)
    {
       return $query
         ->leftJoin('members', 'members.user_id', '=', 'users.id')
         ->where(fn($query) => static::filter($query, $vacancy));
    }
    /**
     * Apply the constraint.
     *
     */
    protected static function filter($query, $vacancy)
    {
        return $query
          ->whereNull('members.org_id')
          ->orWhereNot('members.org_id', $vacancy->org_id);
    }
}

//--------------------------------------------------------------------

namespace App\Search\Sorters;
use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;
class RequirementSorter implements Clause
{
    /**
     * Order the user list by their experience level.
     *
     */
    public static function execute($vacancy, $query)
    {
        $items = $vacancy->requirements->sortBy('optional');
        $items->each(function($item) use (&$query) {
            $query = $query->orderByDesc("item_{$item->id}.years");
        });
        return $query;
    }
}

//----------------------------------------------------------------------

https://chasingcode.dev/blog/refactor-laravel-eloquent-conditions-to-trait/
# _filters

<!-- Contenuto migrato da _docs/_filters.txt -->

https://www.algolia.com/blog/engineering/implementing-faceted-search-with-dynamic-faceting-with-code/  !!!

///--------------------------------------------------------------------

http://tucker-eric.github.io/EloquentFilter/
return User::filter($request->all())->get();

///--------------------------------------------------------------------

https://faun.pub/dynamic-filters-with-laravel-eloquent-2dad9d9ff7c2

///--------------------------------------------------------------------

https://orchid.software/en/project_docs/filters/

https://github.com/pricecurrent/laravel-eloquent-filters

$post = Post::search($query, function ($algolia, $query, $options) use ($category){
    $new_options = [];
    if (!is_null($type)) {
        $new_options = ["facetFilters"=>"category_name:".$category];
    }
    return $algolia->search($query, array_merge($options,$new_options));
});

https://stackoverflow.com/questions/46285500/laravel-scout-search-with-facetfilters

https://docs.meilisearch.com/learn/advanced/filtering_and_faceted_search.html

https://appdividend.com/2022/03/01/how-to-create-filters-in-laravel/  !
