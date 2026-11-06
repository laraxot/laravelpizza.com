<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use PHPUnit\Framework\Assert;

// Si usano i modelli reali che adottano il trait (Page, Section): un'anonymous class
// ereditata da BaseModel farebbe analizzare il trait fuori dal suo contesto e falserebbe
// i tipi dei suoi metodi.
test('HasBlocks trait can be used', function (): void {
    $model = new Page;

    Assert::assertContains(HasBlocks::class, class_uses_recursive($model));
    Assert::assertSame(['title' => 'plain'], $model->compile(['title' => 'plain']));
});

// Filament Blueprint C-3 + FO religion (container0.view, mai localizeURL).
// Under test: Modules\Cms\Models\Traits\HasBlocks::compile. Existing file: this.
// User: «localizeUrl è sbagliato… corretta era route(container0.view)… non rifarlo più».
test('compile renders the allowlisted route expression', function (): void {
    $compiled = (new Page)->compile([
        'nested' => [
            'href' => "{{ route('container0.index',['container0'=>'tickets']) }}",
        ],
    ]);

    Assert::assertIsArray($compiled['nested']);
    Assert::assertIsString($compiled['nested']['href']);
    Assert::assertStringEndsWith('/tickets', $compiled['nested']['href']);
    Assert::assertStringNotContainsString('{{', $compiled['nested']['href']);
});

test('compile leaves localizeURL expressions as text', function (): void {
    $payload = "{{ LaravelLocalization::localizeURL('/tickets') }}";
    Assert::assertSame(
        ['href' => $payload],
        (new Page)->compile(['href' => $payload]),
    );
});

test('compile leaves arbitrary expressions and directives as text', function (string $payload): void {
    Assert::assertSame(['v' => ['deep' => $payload]], (new Page)->compile(['v' => ['deep' => $payload]]));
})->with([
    'arithmetic' => '{{ 1 + 1 }}',
    'function call' => "{{ system('id') }}",
    'allowed callee followed by code' => "{{ route('x') . system('id') }}",
    'directive inside an argument' => "{{ route('@php system(1) @endphp') }}",
    'directive outside the braces' => "@php echo 'pwned'; @endphp {{ 'a' }}",
    'triple braces' => "{{{ system('id') }}}",
    'newline before code' => "{{ route('a')\n . system('id') }}",
    'call inside an array argument' => "{{ route('a', ['b' => system('id')]) }}",
    'verbatim wrapper' => "@verbatim {{ system('id') }} @endverbatim",
    'assignment' => "{{ \$x = system('id') }}",
    'interpolation in a string' => '{{ route("a{$x}") }}',
    'backslash escape in a string' => "{{ route('a\\') . system('id') }}",
]);

test('HasBlocks trait has static method getBlocksBySlug', function (): void {
    $reflection = new ReflectionMethod(Section::class, 'getBlocksBySlug');

    Assert::assertTrue($reflection->isStatic());
    Assert::assertContains(HasBlocks::class, class_uses_recursive(Section::class));
});
