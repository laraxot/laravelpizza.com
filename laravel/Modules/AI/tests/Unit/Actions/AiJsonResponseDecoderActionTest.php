<?php

namespace Modules\AI\Tests\Unit\Actions;

use Modules\AI\Actions\AiJsonResponseDecoderAction;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\AI\Tests\TestCase::class);

describe('AiJsonResponseDecoder Action', function (): void {
    test('_decodes_valid_json_object', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $result = $action->execute('{"key": "value", "number": 42}');

        Assert::assertArrayHasKey('key', $result);
        Assert::assertSame('value', $result['key']);
        Assert::assertArrayHasKey('number', $result);
        Assert::assertSame(42, $result['number']);
    });

    test('_returns_empty_array_for_empty_string', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $result = $action->execute('');

        Assert::assertEmpty($result);
    });

    test('_returns_empty_array_for_whitespace_only', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $result = $action->execute('   ');

        Assert::assertEmpty($result);
    });

    test('_returns_empty_array_for_invalid_json', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $result = $action->execute('{invalid json}');

        Assert::assertEmpty($result);
    });

    test('_returns_empty_array_for_non_object_json', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $result = $action->execute('[1, 2, 3]');

        Assert::assertEmpty($result);
    });

    test('_filters_out_non_string_keys', function (): void {
        $action = new AiJsonResponseDecoderAction;
        // JSON with numeric keys (0-indexed arrays)
        $result = $action->execute('{"0": "first", "1": "second", "name": "John"}');

        // Numeric string keys should be filtered out
        Assert::assertArrayNotHasKey('0', $result);
        Assert::assertArrayNotHasKey('1', $result);
        Assert::assertArrayHasKey('name', $result);
        Assert::assertSame('John', $result['name']);
    });

    test('_decodes_complex_nested_json', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"status": "success", "data": {"id": 123, "items": ["a", "b"]}, "metadata": {"timestamp": "2024-01-01"}}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('status', $result);
        Assert::assertSame('success', $result['status']);
        Assert::assertArrayHasKey('data', $result);
        Assert::assertArrayHasKey('metadata', $result);
        Assert::assertIsArray($result['data']);
        Assert::assertIsArray($result['metadata']);
    });

    test('_decodes_json_with_special_characters', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"message": "Hello, 世界! 🌍", "unicode": "café"}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('message', $result);
        Assert::assertSame('Hello, 世界! 🌍', $result['message']);
        Assert::assertArrayHasKey('unicode', $result);
        Assert::assertSame('café', $result['unicode']);
    });

    test('_decodes_json_with_escaped_quotes', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"quote": "He said \\"Hello\\""}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('quote', $result);
        Assert::assertSame('He said "Hello"', $result['quote']);
    });

    test('_handles_json_with_trailing_whitespace', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"key": "value"}  ';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('key', $result);
        Assert::assertSame('value', $result['key']);
    });

    test('_handles_json_with_leading_whitespace', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '  {"key": "value"}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('key', $result);
        Assert::assertSame('value', $result['key']);
    });

    test('_handles_very_long_json', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $longValue = str_repeat('x', 1000);
        $json = '{"longField": "' . $longValue . '"}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('longField', $result);
        Assert::assertSame($longValue, $result['longField']);
    });

    test('_handles_json_with_null_values', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"field": null, "name": "John"}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('field', $result);
        Assert::assertNull($result['field']);
        Assert::assertArrayHasKey('name', $result);
        Assert::assertSame('John', $result['name']);
    });

    test('_handles_json_with_boolean_values', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"active": true, "disabled": false}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('active', $result);
        Assert::assertTrue($result['active']);
        Assert::assertArrayHasKey('disabled', $result);
        Assert::assertFalse($result['disabled']);
    });

    test('_handles_json_with_floats', function (): void {
        $action = new AiJsonResponseDecoderAction;
        $json = '{"price": 19.99, "rate": 0.5}';
        $result = $action->execute($json);

        Assert::assertArrayHasKey('price', $result);
        Assert::assertSame(19.99, $result['price']);
        Assert::assertArrayHasKey('rate', $result);
        Assert::assertSame(0.5, $result['rate']);
    });
});
