<?php

declare(strict_types=1);

uses(\Modules\Job\Tests\TestCase::class);

use Modules\Job\Actions\GetTaskFrequenciesAction;

describe('GetTaskFrequenciesAction Integration', function () {
    beforeEach(function () {
        $this->action = new GetTaskFrequenciesAction;
    });

    it('returns array when config exists', function () {
        // Set up realistic frequency configuration
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyFiveMinutes' => 'Every 5 Minutes',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result)
            ->toHaveKeys([
                'everyMinute',
                'everyFiveMinutes',
                'hourly',
                'daily',
                'weekly',
                'monthly',
            ])
            ->and($result['everyMinute'])
            ->toBe('Every Minute')
            ->and($result['hourly'])
            ->toBe('Hourly')
            ->and($result['daily'])
            ->toBe('Daily');
    });

    it('throws exception when config is not array', function () {
        // Mock config with non-array value
        config(['totem.frequencies' => 'invalid_value']);

        expect($this->action->execute(...))->toThrow(Exception::class);
    });

    it('throws exception when config is null', function () {
        // Mock config with null value
        config(['totem.frequencies' => null]);

        expect($this->action->execute(...))->toThrow(Exception::class);
    });

    it('handles empty array config', function () {
        config(['totem.frequencies' => []]);

        $result = $this->action->execute();

        expect($result)->toBeArray()->and(count($result))->toBe(0);
    });

    it('can be queued', function () {
        // Test that the action can be queued (basic trait functionality)
        expect(method_exists($this->action, 'onQueue'))->toBeTrue();
    });

    it('integrates with Laravel service container', function () {
        // Test that the action can be resolved from container
        $actionFromContainer = app(GetTaskFrequenciesAction::class);

        expect($actionFromContainer)->toBeInstanceOf(GetTaskFrequenciesAction::class);
    });

    it('handles configuration changes dynamically', function () {
        // Test with initial config
        config(['totem.frequencies' => ['initial' => 'Initial Value']]);
        $result1 = $this->action->execute();

        // Change config
        config(['totem.frequencies' => ['changed' => 'Changed Value']]);
        $result2 = $this->action->execute();

        expect($result1)
            ->toHaveKey('initial')
            ->and($result1['initial'])
            ->toBe('Initial Value')
            ->and($result2)
            ->toHaveKey('changed')
            ->and($result2['changed'])
            ->toBe('Changed Value')
            ->and($result2)
            ->not->toHaveKey('initial');
    });

    it('returns string keys and mixed values', function () {
        config(['totem.frequencies' => [
            'string_key' => 'string_value',
            'another_key' => ['nested', 'array'],
            'numeric_key' => 123,
            'boolean_key' => true,
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result['string_key'])
            ->toBe('string_value')
            ->and($result['another_key'])
            ->toBe(['nested', 'array'])
            ->and($result['numeric_key'])
            ->toBe(123)
            ->and($result['boolean_key'])
            ->toBe(true);
    });

    it('preserves array key types', function () {
        config(['totem.frequencies' => [
            'string_key' => 'value1',
            0 => 'value2',
            1 => 'value3',
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result)
            ->toHaveKey('string_key')
            ->and($result)
            ->toHaveKey(0)
            ->and($result)
            ->toHaveKey(1)
            ->and($result['string_key'])
            ->toBe('value1')
            ->and($result[0])
            ->toBe('value2')
            ->and($result[1])
            ->toBe('value3');
    });

    it('maintains consistency across multiple executions', function () {
        config(['totem.frequencies' => [
            'consistent_key' => 'Consistent Value',
            'another_key' => 'Another Value',
        ]]);

        $results = [];
        for ($i = 0; $i < 3; $i++) {
            $results[] = $this->action->execute();
        }

        // All results should be identical
        foreach ($results as $result) {
            expect($result)->toBe($results[0]);
        }
    });

    it('works with realistic totem configuration', function () {
        // Test with configuration that would be realistic for Laravel Totem
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyFiveMinutes' => 'Every Five Minutes',
            'everyTenMinutes' => 'Every Ten Minutes',
            'everyFifteenMinutes' => 'Every Fifteen Minutes',
            'everyThirtyMinutes' => 'Every Thirty Minutes',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and(count($result))
            ->toBe(10)
            ->and(isset($result['everyMinute']) ? $result['everyMinute'] : null)
            ->toBe('Every Minute')
            ->and(isset($result['hourly']) ? $result['hourly'] : null)
            ->toBe('Hourly')
            ->and(isset($result['daily']) ? $result['daily'] : null)
            ->toBe('Daily')
            ->and(isset($result['weekly']) ? $result['weekly'] : null)
            ->toBe('Weekly')
            ->and(isset($result['monthly']) ? $result['monthly'] : null)
            ->toBe('Monthly')
            ->and(isset($result['yearly']) ? $result['yearly'] : null)
            ->toBe('Yearly');
    });
});
