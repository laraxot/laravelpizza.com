<?php

declare(strict_types=1);

use Modules\Lang\Actions\CleanPlaceholderTranslationsAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\mkdir;

uses(TestCase::class);

test('toglie i segnaposto uguali al nome del campo e lascia le traduzioni vere', function (): void {
    $dir = sys_get_temp_dir().'/lang_clean_'.bin2hex(random_bytes(4));
    mkdir($dir.'/it', 0777, true);
    file_put_contents($dir.'/it/form.php', "<?php\n\nreturn ['fields' => ['route' => ['label' => 'Via', 'placeholder' => 'route', 'helper_text' => 'route'], 'zip' => ['tooltip' => 'zip']]];\n");
    file_put_contents($dir.'/it/dynamic.php', "<?php\n\nreturn ['path' => base_path('x'), 'fields' => ['a' => ['label' => 'a']]];\n");
    file_put_contents($dir.'/it/.php', "<?php\n\nreturn [];\n");

    $report = app(CleanPlaceholderTranslationsAction::class)->execute($dir);

    // 3 segnaposto + il gruppo 'zip' rimasto vuoto.
    Assert::assertSame(4, $report['removed']);
    $form = include $dir.'/it/form.php';
    Assert::assertSame(['fields' => ['route' => ['label' => 'Via']]], $form);
    Assert::assertStringContainsString("base_path('x')", file_get_contents($dir.'/it/dynamic.php'));
    Assert::assertFileDoesNotExist($dir.'/it/.php');
});
