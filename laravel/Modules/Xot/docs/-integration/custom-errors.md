---
title: "custom_errors"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, -integration]
qmd: "custom_errors xot"
---
# custom_errors

<!-- Contenuto migrato da _docs/custom_errors.txt -->

https://tutsforweb.com/how-to-create-custom-404-page-laravel/

public function render($request, Exception $exception)
{
    if ($this->isHttpException($exception)) {
        if (view()->exists('errors.' . $exception->getStatusCode())) {
            return response()->view('errors.' . $exception->getStatusCode(), [], $exception->getStatusCode());
        }
    }

    return parent::render($request, $exception);
}

public function render($request, Exception $exception)
{
    if ($this->isHttpException($exception)) {
        if ($exception->getStatusCode() == 404) {
            return response()->view('errors.' . '404', [], 404);
        }

        if ($exception->getStatusCode() == 500) {
            return response()->view('errors.' . '500', [], 500);
        }
    }

    return parent::render($request, $exception);
}

public function render($request, Exception $exception)
{
    if ($exception instanceof TestingHttpException) {
        return response()->view('errors.testing');
    }
    return parent::render($request, $exception);
}
