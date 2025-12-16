<?php

/**
 * @see https://dev.to/jackmiras/laravels-exceptions-part-2-custom-exceptions-1367
 */

declare(strict_types=1);

namespace Modules\Xot\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Override;

class JsonEncodeException extends ApplicationException
{
    #[Override]
    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    #[Override]
    public function help(): string
    {
        $res = trans('exception.json_not_encoded.help');
        if (! \is_string($res)) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }

        return $res;
    }

    #[Override]
    public function error(): string
    {
        $res = trans('exception.json_not_encoded.error');
        if (! \is_string($res)) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }

        return $res;
    }
}
