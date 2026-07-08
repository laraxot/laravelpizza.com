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


