<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Console\Commands;
use Illuminate\Console\Command;
use Modules\Notify\Console\Commands\AnalyzeTranslationFiles;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('AnalyzeTranslationFiles', function () {
    it('has correct signature', function () {
        $command = new AnalyzeTranslationFiles;

        Assert::assertSame('notify:analyze-translations', $command->getName());
    });

    it('has description', function () {
        $command = new AnalyzeTranslationFiles;

        Assert::assertNotEmpty($command->getDescription());
    });

    it('extends command', function () {
        $command = new AnalyzeTranslationFiles;

        Assert::assertInstanceOf(Command::class, $command);
    });

    it('has handle method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('handle'));
    });

    it('has flatten array method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('flattenArray'));
    });

    it('has analyze structure patterns method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('analyzeStructurePatterns'));
    });

    it('has generate consistency report method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('generateConsistencyReport'));
    });

    it('has generate recommendations method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('generateRecommendations'));
    });

    it('has analyze navigation structure method', function () {
        $reflection = new \ReflectionClass(AnalyzeTranslationFiles::class);

        Assert::assertTrue($reflection->hasMethod('analyzeNavigationStructure'));
    });

    it('flatten array handles nested arrays', function () {
        $command = new AnalyzeTranslationFiles;

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $input = [
            'parent' => [
                'child1' => 'value1',
                'child2' => 'value2',
            ],
        ];

        $result = \assertNotifyArray($method->invoke($command, $input));

        Assert::assertArrayHasKey('parent.child1', $result);
        Assert::assertArrayHasKey('parent.child2', $result);
        Assert::assertSame('value1', $result['parent.child1']);
    });

    it('flatten array handles empty array', function () {
        $command = new AnalyzeTranslationFiles;

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $result = \assertNotifyArray($method->invoke($command, []));

        Assert::assertEmpty($result);
    });

    it('flatten array handles nested levels', function () {
        $command = new AnalyzeTranslationFiles;

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

        $result = \assertNotifyArray($method->invoke($command, $input));

        Assert::assertArrayHasKey('level1.level2.level3', $result);
        Assert::assertSame('deep value', $result['level1.level2.level3']);
    });

    it('flatten array handles prefix parameter', function () {
        $command = new AnalyzeTranslationFiles;

        $reflection = new \ReflectionClass($command);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);

        $input = ['key' => 'value'];

        $result = \assertNotifyArray($method->invoke($command, $input, 'prefix'));

        Assert::assertArrayHasKey('prefix.key', $result);
    });
});
