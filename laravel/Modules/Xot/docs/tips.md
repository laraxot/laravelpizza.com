https://github.com/phpstan/phpstan/issues/1242


protected function callAction(array $match)
{
    list($controller, $method) = $this->breakControllerAndAction(
        $match['action']
    );

    $controllerClass = 'App\\Http\\Controllers\\' . $controller;

    $controllerObject = new $controllerClass($this->request);

    if (method_exists($controllerObject, $method)) {
        $callback = function (...$parameters) use (
            $controllerObject,
            $method
        ) {
            return $controllerObject->$method(...$parameters);
        };

        return call_user_func_array(
            $callback,
            array_merge([$this->request], $match['vars'])
        );
    }

    throw new \Exception("Method not found: {$controllerClass}@{$method}");
}