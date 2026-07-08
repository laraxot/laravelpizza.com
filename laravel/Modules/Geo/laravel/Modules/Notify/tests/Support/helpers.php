<?php

declare(strict_types=1);

use Mockery\MockInterface;

if (! function_exists('typedMock')) {
    /**
     * Mockery::mock() ha un tipo di ritorno nativo generico (LegacyMockInterface),
     * senza estensione PHPStan/Larastan dedicata in questo progetto. Questo helper
     * tipizzato (stesso pattern di Modules/User/tests/Support/helpers.php::typedMock())
     * restituisce l'intersection type reale T&MockInterface, cosi' il mock puo'
     * essere passato a firme che richiedono T senza errori argument.type.
     *
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T&MockInterface
     */
    function typedMock(string $class): MockInterface
    {
        /** @var T&MockInterface $mock */
        $mock = Mockery::mock($class);

        return $mock;
    }
}

if (! function_exists('mockExpectation')) {
    /**
     * Mockery::shouldReceive() dichiara nativamente il tipo di ritorno
     * `Expectation|ExpectationInterface|HigherOrderMessage` (vedi
     * vendor/mockery/mockery/library/Mockery/LegacyMockInterface.php). Quando
     * viene chiamato con un singolo nome di metodo (non un array, non senza
     * argomenti) restituisce sempre una `Expectation` concreta a runtime, ma
     * PHPStan non puo' restringere l'unione in base al valore dell'argomento.
     * Questo helper incapsula quella certezza runtime in un punto solo, cosi'
     * `->with()`, `->andReturn()`, `->once()`, `->times()` restano disponibili
     * senza `method.notFound`/`method.nonObject` sparsi in ogni test.
     */
    function mockExpectation(MockInterface $mock, string $method): \Mockery\Expectation
    {
        /** @var \Mockery\Expectation $expectation */
        $expectation = $mock->shouldReceive($method);

        return $expectation;
    }
}
