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
        return $this->vendorGetParentKeyName();
    }

    public function getQualifiedParentKeyName(): string
    {
        /** @var string $value */
        return $this->vendorGetQualifiedParentKeyName();
    }

    public function getLocalKeyName(): string
    {
        /** @var string $value */
        return $this->vendorGetLocalKeyName();
    }

    public function getQualifiedLocalKeyName(): string
    {
        /** @var string $value */
        return $this->vendorGetQualifiedLocalKeyName();
    }

    public function getDepthName(): string
    {
        /** @var string $value */
        return $this->vendorGetDepthName();
    }

    public function getPathName(): string
    {
        /** @var string $value */
        return $this->vendorGetPathName();
    }

    public function getPathSeparator(): string
    {
        /** @var string $value */
        return $this->vendorGetPathSeparator();
    }

    /**
     * @return array<int|string, string>
     */
    public function getCustomPaths(): array
    {
        /** @var array<int|string, string> $paths */
        return $this->vendorGetCustomPaths();
    }

    public function getExpressionName(): string
    {
        /** @var string $value */
        return $this->vendorGetExpressionName();
    }

    public function ancestors(): Ancestors
    {
        /** @var Ancestors $relation */
        return $this->vendorAncestors();
    }

    public function ancestorsAndSelf(): Ancestors
    {
        /** @var Ancestors $relation */
        return $this->vendorAncestorsAndSelf();
    }

    public function bloodline(): Bloodline
    {
        /** @var Bloodline $relation */
        return $this->vendorBloodline();
    }

    public function children(): HasMany
    {
        /** @var HasMany $relation */
        return $this->vendorChildren();
    }

    public function childrenAndSelf(): Descendants
    {
        /** @var Descendants $relation */
        return $this->vendorChildrenAndSelf();
    }

    public function descendants(): Descendants
    {
        /** @var Descendants $relation */
        return $this->vendorDescendants();
    }

    public function descendantsAndSelf(): Descendants
    {
        /** @var Descendants $relation */
        return $this->vendorDescendantsAndSelf();
    }

    public function parent(): BelongsTo
    {
        /** @var BelongsTo $relation */
        return $this->VendorHasRecursiveRelationships::parent();
    }

    public function parentAndSelf(): Ancestors
    {
        /** @var Ancestors $relation */
        return $this->vendorParentAndSelf();
    }

    public function rootAncestor(): RootAncestor
    {
        /** @var RootAncestor $relation */
        return $this->vendorRootAncestor();
    }

    public function rootAncestorOrSelf(): RootAncestorOrSelf
    {
        /** @var RootAncestorOrSelf $relation */
        return $this->vendorRootAncestorOrSelf();
    }

    public function siblings(): Siblings
    {
        /** @var Siblings $relation */
        return $this->vendorSiblings();
    }

    public function siblingsAndSelf(): Siblings
    {
        /** @var Siblings $relation */
        return $this->vendorSiblingsAndSelf();
    }

    public function getFirstPathSegment(): string
    {
        /** @var string $value */
        return $this->vendorGetFirstPathSegment();
    }

    public function hasNestedPath(): bool
    {
        /** @var bool $result */
        return $this->vendorHasNestedPath();
    }

    public function isIntegerAttribute(string $attribute): bool
    {
        /** @var bool $result */
        return $this->vendorIsIntegerAttribute($attribute);
    }
}
