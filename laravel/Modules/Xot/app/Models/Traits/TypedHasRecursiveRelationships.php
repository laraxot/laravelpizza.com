<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships as VendorHasRecursiveRelationships;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Ancestors;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Bloodline;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Descendants;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\RootAncestor;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\RootAncestorOrSelf;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Siblings;

/**
 * Wrapper trait that re-exposes the vendor recursive relationship helpers
 * with proper return types required by {@see Modules\Xot\Contracts\HasRecursiveRelationshipsContract}.
 */
trait TypedHasRecursiveRelationships
{
    use VendorHasRecursiveRelationships {
        getParentKeyName as protected vendorGetParentKeyName;
        getQualifiedParentKeyName as protected vendorGetQualifiedParentKeyName;
        getLocalKeyName as protected vendorGetLocalKeyName;
        getQualifiedLocalKeyName as protected vendorGetQualifiedLocalKeyName;
        getDepthName as protected vendorGetDepthName;
        getPathName as protected vendorGetPathName;
        getPathSeparator as protected vendorGetPathSeparator;
        getCustomPaths as protected vendorGetCustomPaths;
        getExpressionName as protected vendorGetExpressionName;
        ancestors as protected vendorAncestors;
        ancestorsAndSelf as protected vendorAncestorsAndSelf;
        bloodline as protected vendorBloodline;
        children as protected vendorChildren;
        childrenAndSelf as protected vendorChildrenAndSelf;
        descendants as protected vendorDescendants;
        descendantsAndSelf as protected vendorDescendantsAndSelf;
        parentAndSelf as protected vendorParentAndSelf;
        rootAncestor as protected vendorRootAncestor;
        rootAncestorOrSelf as protected vendorRootAncestorOrSelf;
        siblings as protected vendorSiblings;
        siblingsAndSelf as protected vendorSiblingsAndSelf;
        getFirstPathSegment as protected vendorGetFirstPathSegment;
        hasNestedPath as protected vendorHasNestedPath;
        isIntegerAttribute as protected vendorIsIntegerAttribute;
    }

    public function getParentKeyName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetParentKeyName();

        return $value;
    }

    public function getQualifiedParentKeyName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetQualifiedParentKeyName();

        return $value;
    }

    public function getLocalKeyName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetLocalKeyName();

        return $value;
    }

    public function getQualifiedLocalKeyName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetQualifiedLocalKeyName();

        return $value;
    }

    public function getDepthName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetDepthName();

        return $value;
    }

    public function getPathName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetPathName();

        return $value;
    }

    public function getPathSeparator(): string
    {
        /** @var string $value */
        $value = $this->vendorGetPathSeparator();

        return $value;
    }

    /**
     * @return array<int|string, string>
     */
    public function getCustomPaths(): array
    {
        /** @var array<int|string, string> $paths */
        $paths = $this->vendorGetCustomPaths();

        return $paths;
    }

    public function getExpressionName(): string
    {
        /** @var string $value */
        $value = $this->vendorGetExpressionName();

        return $value;
    }

    public function ancestors(): Ancestors
    {
        /** @var Ancestors $relation */
        $relation = $this->vendorAncestors();

        return $relation;
    }

    public function ancestorsAndSelf(): Ancestors
    {
        /** @var Ancestors $relation */
        $relation = $this->vendorAncestorsAndSelf();

        return $relation;
    }

    public function bloodline(): Bloodline
    {
        /** @var Bloodline $relation */
        $relation = $this->vendorBloodline();

        return $relation;
    }

    public function children(): HasMany
    {
        /** @var HasMany $relation */
        $relation = $this->vendorChildren();

        return $relation;
    }

    public function childrenAndSelf(): Descendants
    {
        /** @var Descendants $relation */
        $relation = $this->vendorChildrenAndSelf();

        return $relation;
    }

    public function descendants(): Descendants
    {
        /** @var Descendants $relation */
        $relation = $this->vendorDescendants();

        return $relation;
    }

    public function descendantsAndSelf(): Descendants
    {
        /** @var Descendants $relation */
        $relation = $this->vendorDescendantsAndSelf();

        return $relation;
    }

    public function parent(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->VendorHasRecursiveRelationships::parent();

        return $relation;
    }

    public function parentAndSelf(): Ancestors
    {
        /** @var Ancestors $relation */
        $relation = $this->vendorParentAndSelf();

        return $relation;
    }

    public function rootAncestor(): RootAncestor
    {
        /** @var RootAncestor $relation */
        $relation = $this->vendorRootAncestor();

        return $relation;
    }

    public function rootAncestorOrSelf(): RootAncestorOrSelf
    {
        /** @var RootAncestorOrSelf $relation */
        $relation = $this->vendorRootAncestorOrSelf();

        return $relation;
    }

    public function siblings(): Siblings
    {
        /** @var Siblings $relation */
        $relation = $this->vendorSiblings();

        return $relation;
    }

    public function siblingsAndSelf(): Siblings
    {
        /** @var Siblings $relation */
        $relation = $this->vendorSiblingsAndSelf();

        return $relation;
    }

    public function getFirstPathSegment(): string
    {
        /** @var string $value */
        $value = $this->vendorGetFirstPathSegment();

        return $value;
    }

    public function hasNestedPath(): bool
    {
        /** @var bool $result */
        $result = $this->vendorHasNestedPath();

        return $result;
    }

    public function isIntegerAttribute(string $attribute): bool
    {
        /** @var bool $result */
        $result = $this->vendorIsIntegerAttribute($attribute);

        return $result;
    }
}
