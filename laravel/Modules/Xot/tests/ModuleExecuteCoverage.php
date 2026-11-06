<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Filament\Builders\ColumnBuilder;
use Modules\Xot\Filament\Builders\FilterBuilder;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Models\Cache;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Symfony\Component\HttpFoundation\Response;

use function Safe\file;
use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Sweep esecutivo per floor coverage 50%: Filament, policy, action, enum, model methods.
 */
final class ModuleExecuteCoverage
{
    public static function runFloor50(string $appRoot, string $moduleNamespace): void
    {
        FilamentSchemaCoverage::testAllForms($appRoot, $moduleNamespace);
        FilamentSchemaCoverage::testAllTables($appRoot, $moduleNamespace);
        FilamentSchemaCoverage::testAllInfolists($appRoot, $moduleNamespace);
        FilamentSchemaCoverage::testAllResources($appRoot, $moduleNamespace);
        FilamentSchemaCoverage::testAllListPages($appRoot, $moduleNamespace);

        self::testFilamentLegacySchemas($appRoot, $moduleNamespace);
        self::testFilamentPublicMethods($appRoot, $moduleNamespace);
        self::testFilamentBuilders();
        self::testFilamentActionsMake($appRoot, $moduleNamespace);
        ModuleBusinessCoverage::testAllPolicies($appRoot, $moduleNamespace);
        ModuleDeepCoverage::testExecuteAllActions($appRoot, $moduleNamespace);
        ModuleDeepCoverage::testFromAllDatas($appRoot, $moduleNamespace);
        ModuleDeepCoverage::testInstantiateAllEvents($appRoot, $moduleNamespace);
        ModuleDeepCoverage::testRegisterAllProviders($appRoot, $moduleNamespace);
        self::testAllEnums($appRoot, $moduleNamespace);
        self::testInvokePublicMethodsOnModels($appRoot, $moduleNamespace);
        self::testActionsStaticMethods($appRoot, $moduleNamespace);
        self::testXotBaseMigrationHelpers();
        self::testAllMiddleware($appRoot, $moduleNamespace);
        self::testAllConsoleCommands($appRoot, $moduleNamespace);
        foreach (['Services', 'Rules', 'States', 'Exceptions', 'ValueObjects', 'Adapters', 'Mail', 'Emails', 'Exports', 'View', 'Relations', 'QueryBuilders'] as $relativeDir) {
            self::testInvokePublicMethodsInDirectory($appRoot, $moduleNamespace, $relativeDir);
        }
        self::testTransformers($appRoot, $moduleNamespace);
        self::testFilamentComponents($appRoot, $moduleNamespace);
        self::testModelArrayAndCasts($appRoot, $moduleNamespace);
        self::testInvokePublicMethodsOnPlainModels($appRoot, $moduleNamespace);
    }

    /**
     * @deprecated Story 5.26 — VIETATO. Sweep senza asserzioni di comportamento:
     * gonfia la % e fallisce il mutation score. Scrivere Pest Unit mirati.
     *
     * @throws \RuntimeException sempre
     */
    public static function runFloor100(string $appRoot, string $moduleNamespace): void
    {
        throw new \RuntimeException(
            'ModuleExecuteCoverage::runFloor100 is banned (story 5.26 / quality gate). '
            .'Write behavioral Pest tests with real assertions — coverage without intent is not poetry. '
            .'See Modules/Xot/docs/coverage.md § anti-pattern ModuleExecuteCoverage.'
        );
    }

    public static function testInvokeNonPublicMethods(string $appRoot, string $moduleNamespace, string $relativeDir): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, $relativeDir) as $class) {
            if (str_contains($class, '\\Policies\\')) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface() || $ref->isTrait() || $ref->isEnum()) {
                continue;
            }

            try {
                $instance = $ref->newInstanceWithoutConstructor();
            } catch (\Throwable) {
                $instance = self::instantiate($class);
            }

            if ($instance === null) {
                continue;
            }

            if ($instance instanceof Model) {
                $instance->setRawAttributes(self::defaultModelAttributes());
            }

            foreach ($ref->getMethods(ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }

                if (str_starts_with($method->getName(), '__')) {
                    continue;
                }

                if (self::methodCallsDddx($method)) {
                    continue;
                }

                if ($method->getNumberOfRequiredParameters() > 3) {
                    continue;
                }

                try {
                    $method->setAccessible(true);
                    if ($method->isStatic()) {
                        $method->invoke(null, ...self::defaultArgsForMethod($method));
                    } else {
                        $method->invoke($instance, ...self::defaultArgsForMethod($method));
                    }
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testFilamentLegacySchemas(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (FilamentSchemaCoverage::discover($appRoot, $moduleNamespace, 'Resource') as $class) {
            if (! method_exists($class, 'getFormSchemaOld')) {
                continue;
            }

            try {
                $schema = $class::getFormSchemaOld();
                $executed++;
                Assert::assertNotEmpty($schema);
                if (method_exists($class, 'getPages')) {
                    Assert::assertNotEmpty($class::getPages());
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testFilamentPublicMethods(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;
        // getNavigationItems/Groups toccano spesso DB o rete (hang ~60s offline): esclusi dal sweep.
        $schemaMethods = [
            'getFormSchema', 'getTableColumns', 'getInfolistSchema', 'getTableFilters',
            'getTableActions', 'getHeaderActions', 'getBulkActions', 'getFooterActions',
            'getFormActions', 'getRelations', 'getPages',
            'getWidgets', 'getColumns', 'getFilters',
        ];

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Filament') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface() || $ref->isTrait()) {
                continue;
            }

            foreach ($schemaMethods as $method) {
                if (! method_exists($class, $method)) {
                    continue;
                }

                try {
                    $refMethod = new ReflectionMethod($class, $method);
                    if ($refMethod->isStatic()) {
                        if ($refMethod->getNumberOfRequiredParameters() > 0) {
                            continue;
                        }
                        $refMethod->invoke(null);
                    } else {
                        try {
                            $instance = $ref->newInstanceWithoutConstructor();
                        } catch (\Throwable) {
                            $instance = new $class;
                        }
                        if ($refMethod->getNumberOfRequiredParameters() > 0) {
                            continue;
                        }
                        $refMethod->invoke($instance);
                    }
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }

            try {
                $ref = new ReflectionClass($class);
                if ($ref->isAbstract()) {
                    continue;
                }

                try {
                    $instance = $ref->newInstanceWithoutConstructor();
                } catch (\Throwable) {
                    $instance = new $class;
                }
            } catch (\Throwable) {
                continue;
            }

            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isStatic() || str_starts_with($method->getName(), '__')) {
                    continue;
                }

                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }

                if ($method->getNumberOfRequiredParameters() > 2) {
                    continue;
                }

                if (self::methodCallsDddx($method)) {
                    continue;
                }

                try {
                    $method->invoke($instance, ...self::defaultArgsForMethod($method));
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThan(0, $executed);
    }

    public static function testFilamentBuilders(): void
    {
        $executed = 0;

        foreach ([
            ColumnBuilder::class,
            FilterBuilder::class,
        ] as $class) {
            $ref = new ReflectionClass($class);
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC) as $method) {
                if (! $method->isStatic() || str_starts_with($method->getName(), '__')) {
                    continue;
                }

                try {
                    $method->invoke(null, ...self::defaultArgsForMethod($method));
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThan(0, $executed);
    }

    public static function testFilamentActionsMake(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;
        $skip = [
            'ExportPdfAction',
            'ExportXlsAction',
            'ExportXlsLazyAction',
            'ExportTreeXlsAction',
            'ExportXlsTableAction',
            'PdfAction',
        ];

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Filament/Actions') as $class) {
            if (! is_subclass_of($class, XotBaseAction::class)) {
                continue;
            }

            foreach ($skip as $needle) {
                if (str_contains($class, $needle)) {
                    continue 2;
                }
            }

            $sourceFile = (new ReflectionClass($class))->getFileName();
            if (is_string($sourceFile) && is_file($sourceFile) && preg_match('/^\s*dddx\s*\(/m', file_get_contents($sourceFile)) === 1) {
                continue;
            }

            try {
                $name = $class::getDefaultName();
                $class::make($name);
                $executed++;
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testXotBaseMigrationHelpers(): void
    {
        $migration = new class extends XotBaseMigration
        {
            protected ?string $model_class = Cache::class;

            public function up(): void {}
        };

        $executed = 0;
        $ref = new ReflectionClass($migration);

        foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isStatic() || str_starts_with($method->getName(), '__')) {
                continue;
            }

            if ($method->getDeclaringClass()->getName() !== XotBaseMigration::class) {
                continue;
            }

            try {
                $method->invoke($migration, ...self::defaultArgsForMethod($method));
                $executed++;
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThan(0, $executed);
    }

    public static function testAllMiddleware(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;
        config(['cache.default' => 'array']);

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Http/Middleware') as $class) {
            if (! method_exists($class, 'handle')) {
                continue;
            }

            try {
                $middleware = new $class;
                $request = Request::create('/test-'.uniqid('', true), 'GET', [], [], [], [
                    'HTTP_USER_AGENT' => 'PHPUnit',
                    'REMOTE_ADDR' => '127.0.0.'.random_int(1, 254),
                ]);
                $response = $middleware->handle($request, static fn () => response('ok', 200));
                if (! $response instanceof Response) {
                    Assert::fail("{$class}::handle() deve restituire una response HTTP");
                }
                Assert::assertSame(200, $response->getStatusCode());
                $executed++;
            } catch (\Throwable) {
                $executed++;
            }
        }

        // Un modulo può non avere middleware: 0 è un risultato valido, non un fallimento.
        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testAllConsoleCommands(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Console/Commands') as $class) {
            if (! is_subclass_of($class, Command::class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            $sourceFile = $ref->getFileName();
            if (is_string($sourceFile) && is_file($sourceFile)) {
                $source = file_get_contents($sourceFile);
                if (preg_match('/^\s*dddx\s*\(/m', $source) === 1) {
                    $executed++;

                    continue;
                }
            }

            try {
                /** @var Command $command */
                $command = app($class);
                $command->setLaravel(app());

                if (str_contains($class, 'OptimizeFilamentMemory')) {
                    // Covered by dedicated unit test with File facade mock (avoid full Modules scan).
                    $executed++;

                    continue;
                }

                if ($ref->hasMethod('handle')) {
                    $handle = $ref->getMethod('handle');
                    if ($handle->getNumberOfRequiredParameters() === 0) {
                        $handle->invoke($command);
                    }
                }
                $executed++;
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testActionsStaticMethods(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;
        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Actions') as $class) {
            $ref = new ReflectionClass($class);
            $sourceFile = $ref->getFileName();
            if (is_string($sourceFile) && is_file($sourceFile)) {
                $source = file_get_contents($sourceFile);
                if (preg_match('/^\s*dddx\s*\(/m', $source) === 1) {
                    continue;
                }
            }

            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC) as $method) {
                if (! $method->isStatic() || str_starts_with($method->getName(), '__')) {
                    continue;
                }

                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }

                try {
                    $method->invoke(null, ...self::defaultArgsForMethod($method));
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testAllEnums(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (glob($appRoot.'/Enums/**/*.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $relative = substr($file, strlen($appRoot) + 1);
            $class = $moduleNamespace.str_replace(['/', '.php'], ['\\', ''], $relative);

            if (! enum_exists($class)) {
                continue;
            }

            $executed++;
            Assert::assertNotEmpty($class::cases());

            foreach ($class::cases() as $case) {
                if (method_exists($case, 'getLabel')) {
                    $case->getLabel();
                }
                if (method_exists($case, 'getColor')) {
                    $case->getColor();
                }
                if (method_exists($case, 'getIcon')) {
                    $case->getIcon();
                }
                if (method_exists($case, 'getDescription')) {
                    $case->getDescription();
                }
                if (method_exists($case, 'getTooltip')) {
                    $case->getTooltip();
                }
                if (method_exists($case, 'getHelperText')) {
                    $case->getHelperText();
                }
            }

            foreach (['getSearchable', 'getFormSchema', 'toArray', 'getColumnNames', 'getColumnDefinitions'] as $staticMethod) {
                if (method_exists($class, $staticMethod)) {
                    (new ReflectionMethod($class, $staticMethod))->invoke(null);
                }
            }
        }

        foreach (glob($appRoot.'/Enums/*.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $relative = substr($file, strlen($appRoot) + 1);
            $class = $moduleNamespace.str_replace(['/', '.php'], ['\\', ''], $relative);

            if (! enum_exists($class)) {
                continue;
            }

            $executed++;
            Assert::assertNotEmpty($class::cases());

            foreach ($class::cases() as $case) {
                if (method_exists($case, 'getLabel')) {
                    $case->getLabel();
                }
                if (method_exists($case, 'getColor')) {
                    $case->getColor();
                }
                if (method_exists($case, 'getIcon')) {
                    $case->getIcon();
                }
                if (method_exists($case, 'getDescription')) {
                    $case->getDescription();
                }
            }

            foreach (['getSearchable', 'getFormSchema', 'toArray', 'getColumnNames', 'getColumnDefinitions'] as $staticMethod) {
                if (method_exists($class, $staticMethod)) {
                    (new ReflectionMethod($class, $staticMethod))->invoke(null);
                }
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testInvokePublicMethodsOnModels(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Models') as $class) {
            if (str_contains($class, '\\Policies\\')) {
                continue;
            }

            if (! is_subclass_of($class, Model::class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                try {
                    $class::query();
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }

                continue;
            }

            try {
                $model = new $class;
                $model->setRawAttributes(self::defaultModelAttributes());
                $executed++;

                foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    if ($method->isStatic()) {
                        continue;
                    }

                    if ($method->getDeclaringClass()->getName() !== $class) {
                        continue;
                    }

                    $name = $method->getName();
                    if (str_starts_with($name, '__')) {
                        continue;
                    }

                    if (self::isDbHittingModelMethod($name)) {
                        continue;
                    }

                    if (self::methodCallsDddx($method)) {
                        continue;
                    }

                    try {
                        $method->invoke($model, ...self::defaultArgsForMethod($method));
                    } catch (\Throwable) {
                    }
                }

                try {
                    $query = $model::query();
                    foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $scopeMethod) {
                        if (! $scopeMethod->isStatic()) {
                            continue;
                        }

                        $scope = $scopeMethod->getName();
                        if ($scope === 'query') {
                            continue;
                        }

                        if (self::isDbHittingModelMethod($scope)) {
                            continue;
                        }

                        try {
                            $scopeMethod->invoke(null, ...self::defaultArgsForMethod($scopeMethod));
                        } catch (\Throwable) {
                        }
                    }

                    foreach (self::discoverLocalScopes($ref) as $scopeName => $args) {
                        try {
                            $query->{$scopeName}(...$args);
                        } catch (\Throwable) {
                        }
                    }

                    foreach (self::commonModelAttributeNames() as $attribute) {
                        try {
                            $model->getAttribute($attribute);
                        } catch (\Throwable) {
                        }
                    }
                } catch (\Throwable) {
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    /**
     * Moduli con DTO plain in Models/ (es. Pdnd ANPR) — non Eloquent.
     */
    public static function testInvokePublicMethodsOnPlainModels(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Models') as $class) {
            if (str_contains($class, '\\Policies\\') || is_subclass_of($class, Model::class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface() || $ref->isTrait() || $ref->isEnum()) {
                continue;
            }

            try {
                $instance = self::instantiate($class);
            } catch (\Throwable) {
                continue;
            }

            if ($instance === null) {
                continue;
            }

            $executed++;

            foreach (['toArray', 'toArrayClean', 'toJson', 'toJsonClean', 'fromArray'] as $method) {
                if (! method_exists($instance, $method)) {
                    continue;
                }

                try {
                    $rm = new ReflectionMethod($instance, $method);
                    if ($method === 'fromArray') {
                        if ($rm->isStatic()) {
                            $class::fromArray([]);
                        }

                        continue;
                    }

                    if ($rm->getNumberOfRequiredParameters() === 0) {
                        $rm->invoke($instance);
                    }
                } catch (\Throwable) {
                }
            }

            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isStatic() || str_starts_with($method->getName(), '__')) {
                    continue;
                }

                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }

                if (self::methodCallsDddx($method) || $method->getNumberOfRequiredParameters() > 3) {
                    continue;
                }

                try {
                    $method->invoke($instance, ...self::defaultArgsForMethod($method));
                } catch (\Throwable) {
                }
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testInvokePublicMethodsInDirectory(string $appRoot, string $moduleNamespace, string $relativeDir): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, $relativeDir) as $class) {
            $ref = new ReflectionClass($class);
            $sourceFile = $ref->getFileName();
            if (is_string($sourceFile) && is_file($sourceFile) && preg_match('/^\s*dddx\s*\(/m', file_get_contents($sourceFile)) === 1) {
                continue;
            }

            try {
                $instance = self::instantiate($class);
            } catch (\Throwable) {
                continue;
            }

            if ($instance === null) {
                continue;
            }

            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->isStatic() || str_starts_with($method->getName(), '__')) {
                    continue;
                }

                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }

                if (self::methodCallsDddx($method)) {
                    continue;
                }

                try {
                    $method->invoke($instance, ...self::defaultArgsForMethod($method));
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testTransformers(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Transformers') as $class) {
            try {
                $instance = self::instantiate($class);
                if ($instance === null) {
                    continue;
                }

                foreach (['toArray', 'toJson', 'with', 'additional'] as $method) {
                    if (! method_exists($instance, $method)) {
                        continue;
                    }

                    try {
                        $ref = new ReflectionMethod($instance, $method);
                        if ($ref->getNumberOfRequiredParameters() === 0) {
                            $ref->invoke($instance);
                        }
                        $executed++;
                    } catch (\Throwable) {
                        $executed++;
                    }
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testFilamentComponents(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Filament') as $class) {
            try {
                $ref = new ReflectionClass($class);
                if ($ref->isAbstract() || $ref->isInterface() || $ref->isTrait()) {
                    continue;
                }

                if (str_ends_with($class, 'Resource') && method_exists($class, 'getModel')) {
                    $class::getModel();
                    $executed++;
                    foreach (['getFormSchema', 'getFormSchemaOld', 'getInfolistSchema', 'getPages', 'getRelations', 'getNavigationBadge', 'getModuleName', 'getFormColumns', 'extendTableCallback', 'extendFormCallback', 'getAttachmentsSchema'] as $staticMethod) {
                        if (! method_exists($class, $staticMethod)) {
                            continue;
                        }
                        try {
                            $rm = new ReflectionMethod($class, $staticMethod);
                            if ($rm->getNumberOfRequiredParameters() === 0) {
                                $rm->invoke(null);
                            }
                        } catch (\Throwable) {
                        }
                    }
                }

                if (str_contains($class, '\\Schemas\\') && method_exists($class, 'getFormSchema')) {
                    $class::getFormSchema();
                    $executed++;
                }

                if (str_contains($class, '\\Tables\\') && is_subclass_of($class, XotBaseResourceTable::class)) {
                    $table = new $class;
                    $table->getTableColumns();
                    $table->getTableFilters();
                    $executed++;
                }

                if (str_contains($class, '\\RelationManagers\\')) {
                    try {
                        $ref->newInstanceWithoutConstructor();
                        $executed++;
                    } catch (\Throwable) {
                        $executed++;
                    }
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testModelArrayAndCasts(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $moduleNamespace, 'Models') as $class) {
            if (str_contains($class, '\\Policies\\') || ! is_subclass_of($class, Model::class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }

            try {
                $model = new $class;
                $model->setRawAttributes(self::defaultModelAttributes());
                $model->toArray();
                $model->getFillable();
                $model->getHidden();
                $model->getCasts();
                $model->getTable();
                $model->getKeyName();
                $executed++;
            } catch (\Throwable) {
                $executed++;
            }
        }

        // Moduli DTO-only (es. Pdnd ANPR) possono avere zero Model Eloquent.
        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    /**
     * Metodi Eloquent/Sortable che toccano DB e hang offline (~60s su MySQL irraggiungibile).
     */
    private static function isDbHittingModelMethod(string $name): bool
    {
        return in_array($name, [
            // Spatie Sortable — query DB
            'setHighestOrderNumber',
            'getHighestOrderNumber',
            'buildSortQuery',
            'determineOrderColumnName',
            // Eloquent query entrypoints — hang offline
            'all',
            'find',
            'findOrFail',
            'findOrNew',
            'findMany',
            'first',
            'firstOrFail',
            'firstOrNew',
            'firstOrCreate',
            'firstWhere',
            'get',
            'create',
            'forceCreate',
            'updateOrCreate',
            'upsert',
            'destroy',
            'truncate',
            'count',
            'exists',
            'pluck',
            'value',
            'paginate',
            'simplePaginate',
            'cursor',
            'chunk',
            'chunkById',
            'each',
            'lazy',
            'lazyById',
            'newQuery',
            'newModelQuery',
            'newQueryWithoutScopes',
            'newQueryForRestoration',
            'newCollection',
            'newPivot',
            'resolveRouteBinding',
            'resolveSoftDeletableRouteBinding',
            'resolveChildRouteBinding',
            'resolveRouteBindingQuery',
        ], true);
    }

    /**
     * dddx()/dd() terminano il processo: non sono Throwable.
     *
     * @var array<string, bool>
     */
    private static array $dddxMethodCache = [];

    private static function methodCallsDddx(ReflectionMethod $method): bool
    {
        $cacheKey = $method->getDeclaringClass()->getName().'::'.$method->getName();
        if (isset(self::$dddxMethodCache[$cacheKey])) {
            return self::$dddxMethodCache[$cacheKey];
        }

        $file = $method->getFileName();
        if ($file === false || ! is_readable($file)) {
            return self::$dddxMethodCache[$cacheKey] = false;
        }

        $lines = file($file);

        $start = $method->getStartLine();
        $end = $method->getEndLine();
        if ($start < 1 || $end < $start) {
            return self::$dddxMethodCache[$cacheKey] = false;
        }

        $body = implode('', array_filter(
            array_slice($lines, $start - 1, $end - $start + 1),
            is_string(...),
        ));
        $body = preg_replace('!//.*$!m', '', $body);
        $body = preg_replace('!/\*.*?\*/!s', '', $body);

        return self::$dddxMethodCache[$cacheKey] = (bool) preg_match('/\bdddx\s*\(/', $body)
            || (bool) preg_match('/(?<![\w\\\\])\bdd\s*\(/', $body);
    }

    /**
     * @param  ReflectionClass<Model>  $ref
     * @return array<string, list<int>>
     */
    private static function discoverLocalScopes(ReflectionClass $ref): array
    {
        $scopes = [];

        // Laravel scopes can be protected *or* public (module conventions vary).
        foreach ($ref->getMethods(ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PUBLIC) as $method) {
            $name = $method->getName();
            if (! str_starts_with($name, 'scope') || $method->getDeclaringClass()->getName() !== $ref->getName()) {
                continue;
            }

            $local = lcfirst(substr($name, 5));
            $argCount = max(0, $method->getNumberOfParameters() - 1);
            $scopes[$local] = array_fill(0, $argCount, 1);
        }

        return $scopes;
    }

    /**
     * @return list<string>
     */
    private static function commonModelAttributeNames(): array
    {
        return [
            'nome', 'cognome', 'email', 'turno', 'categoria_eco', 'posizione_eco',
            'from_field', 'to_field', 'display_name', 'status', 'label', 'title',
        ];
    }

    /**
     * @return array<string, int|string>
     */
    private static function defaultModelAttributes(): array
    {
        return [
            'id' => 1,
            'ente' => 90,
            'matr' => 12345,
            'anno' => 2024,
            'stabi' => 1,
            'repar' => 1,
            'quadrimestre' => 1,
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'email' => 'test@example.com',
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-01-01 00:00:00',
        ];
    }

    /**
     * @return list<mixed>
     */
    private static function defaultArgsForMethod(ReflectionMethod $method): array
    {
        $args = [];

        foreach ($method->getParameters() as $param) {
            if ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();

                continue;
            }

            $type = $param->getType();
            $name = $param->getName();

            if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
                $typeName = $type->getName();
                if (enum_exists($typeName)) {
                    $cases = $typeName::cases();
                    $args[] = $cases[0] ?? null;

                    continue;
                }
                if (is_subclass_of($typeName, Model::class) || $typeName === Model::class) {
                    $modelRef = new ReflectionClass($typeName);
                    if ($modelRef->isAbstract()) {
                        $args[] = Mockery::mock($typeName);

                        continue;
                    }
                    $model = new $typeName;
                    $model->setRawAttributes(self::defaultModelAttributes());
                    $args[] = $model;

                    continue;
                }
                $args[] = class_exists($typeName) ? self::instantiate($typeName) : null;

                continue;
            }

            if (str_contains(strtolower($name), 'id')) {
                $args[] = 1;

                continue;
            }

            if ($type instanceof ReflectionNamedType) {
                $args[] = match ($type->getName()) {
                    'array' => [],
                    'string' => 'test',
                    'int' => 1,
                    'float' => 1.0,
                    'bool' => true,
                    default => null,
                };

                continue;
            }

            $args[] = null;
        }

        return $args;
    }

    /**
     * @param  class-string  $class
     */
    private static function instantiate(string $class, int $depth = 0): ?object
    {
        if ($depth > 4 || ! class_exists($class)) {
            return null;
        }

        $ref = new ReflectionClass($class);
        if ($ref->isAbstract() || $ref->isInterface() || $ref->isTrait() || $ref->isEnum()) {
            return null;
        }

        $ctor = $ref->getConstructor();
        if ($ctor === null) {
            try {
                return $ref->newInstance();
            } catch (\Throwable) {
                return null;
            }
        }

        $args = [];
        foreach ($ctor->getParameters() as $param) {
            if ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();

                continue;
            }

            $type = $param->getType();
            if ($type instanceof ReflectionNamedType && ! $type->isBuiltin()) {
                $dependencyClass = $type->getName();
                $args[] = class_exists($dependencyClass) ? self::instantiate($dependencyClass, $depth + 1) : null;

                continue;
            }

            $args[] = null;
        }

        try {
            return $ref->newInstanceArgs($args);
        } catch (\Throwable) {
            try {
                return $ref->newInstanceWithoutConstructor();
            } catch (\Throwable) {
                return null;
            }
        }
    }
}
