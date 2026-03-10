<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Console\Commands;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Console\Commands\AnalyzeTranslationFiles;

describe('AnalyzeTranslationFiles', function () {
    it('has correct signature', function () {
        $command = new AnalyzeTranslationFiles();

        expect($command->getName())->toBe('notify:analyze-translations');
    });

    it('has description', function () {
        $command = new AnalyzeTranslationFiles();

        $description = $command->getDescription();

        expect($description)->not->toBeEmpty();
        expect($description)->toBeString();
    });

    it('extends command', function () {
        $command = new AnalyzeTranslationFiles();

        expect($command)->toBeInstanceOf(\Illuminate\Console\Command::class);
    });

    it('has handle method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'handle'))->toBeTrue();
    });

    it('has flatten array method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'flattenArray'))->toBeTrue();
    });

    it('has analyze structure patterns method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'analyzeStructurePatterns'))->toBeTrue();
    });

    it('has generate consistency report method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'generateConsistencyReport'))->toBeTrue();
    });

    it('has generate recommendations method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'generateRecommendations'))->toBeTrue();
    });

    it('has analyze navigation structure method', function () {
        $command = new AnalyzeTranslationFiles();

        expect(method_exists($command, 'analyzeNavigationStructure'))->toBeTrue();
    });

    it('flatten array handles nested arrays', function () {
        $command = new AnalyzeTranslationFiles();

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $input = [
            'parent' => [
                'child1' => 'value1',
                'child2' => 'value2',
            ],
        ];

        $result = $method->invoke($command, $input);

        expect($result)->toHaveKey('parent.child1');
        expect($result)->toHaveKey('parent.child2');
        expect($result['parent.child1'])->toBe('value1');
    });

    it('flatten array handles empty array', function () {
        $command = new AnalyzeTranslationFiles();

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $result = $method->invoke($command, []);

        expect($result)->toBeEmpty();
    });

    it('flatten array handles nested levels', function () {
        $command = new AnalyzeTranslationFiles();

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $input = [
            'level1' => [
                'level2' => [
                    'level3' => 'deep value',
                ],
            ],
        ];

        $result = $method->invoke($command, $input);

        expect($result)->toHaveKey('level1.level2.level3');
        expect($result['level1.level2.level3'])->toBe('deep value');
    });

    it('flatten array handles prefix parameter', function () {
        $command = new AnalyzeTranslationFiles();

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $input = ['key' => 'value'];

        $result = $method->invoke($command, $input, 'prefix');

        expect($result)->toHaveKey('prefix.key');
    });
});
