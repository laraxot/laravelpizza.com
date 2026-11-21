---
issues: []
discussions: []
title: "_pivot"
module: "Xot"
type: concept
tags: [pivot, 2]
created: 2026-07-14
updated: 2026-07-14
qmd: "pivot 2"
related:
  - "./eloquent-magic-properties-rule.md"
---
# _pivot

<!-- Contenuto migrato da _docs/_pivot.txt -->

https://github.com/larastan/larastan/issues/515

**
 * @extends JsonResource<\App\User>
*/
class UserResource extends JsonResource
{
    // Other parts of the resource omitted
    public function toArray($request)
    {
        /** @var \App\User **/
        $user = $this;
        return [
              "time_to_live" => $this->whenPivotLoaded("table", function () use($user) {
                return $user->getRelationValue("pivot")->time_to_live;  // This is the line 45
            })
         ];
      }
}
