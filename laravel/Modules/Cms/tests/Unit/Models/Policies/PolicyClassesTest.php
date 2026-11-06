<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\CmsBasePolicy;
use Modules\Cms\Models\Policies\ConfPolicy;
use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\ModulePolicy;
use Modules\Cms\Models\Policies\PageContentPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

test('CmsBasePolicy is an abstract class', function () {
    $reflection = new ReflectionClass(CmsBasePolicy::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('PagePolicy can be instantiated', function () {
    Assert::assertSame(PagePolicy::class, (new PagePolicy)::class);

});

test('SectionPolicy can be instantiated', function () {
    Assert::assertSame(SectionPolicy::class, (new SectionPolicy)::class);

});

test('PageContentPolicy can be instantiated', function () {
    Assert::assertSame(PageContentPolicy::class, (new PageContentPolicy)::class);

});

test('ConfPolicy can be instantiated', function () {
    Assert::assertSame(ConfPolicy::class, (new ConfPolicy)::class);

});

test('MenuPolicy can be instantiated', function () {
    Assert::assertSame(MenuPolicy::class, (new MenuPolicy)::class);

});

test('ModulePolicy can be instantiated', function () {
    Assert::assertSame(ModulePolicy::class, (new ModulePolicy)::class);

});

test('PagePolicy grants abilities from the page.* permissions', function () {
    $policy = new PagePolicy;
    $user = cmsCreateMock(UserContract::class);
    $user->method('hasPermissionTo')->willReturnCallback(
        static fn (mixed $permission): bool => $permission === 'page.viewAny',
    );

    Assert::assertTrue($policy->viewAny($user));
    Assert::assertFalse($policy->create($user));
});

test('CmsBasePolicy before() short-circuits only for super-admin', function () {
    $policy = new PagePolicy;
    $admin = cmsCreateMock(UserContract::class);
    $admin->method('hasRole')->willReturn(true);
    $user = cmsCreateMock(UserContract::class);
    $user->method('hasRole')->willReturn(false);

    Assert::assertTrue($policy->before($admin, 'viewAny'));
    Assert::assertNull($policy->before($user, 'viewAny'));
});
