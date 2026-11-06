<?php

declare(strict_types=1);
/**
 * This is the start of the PHP code block.
 */

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Http\Controllers\XotBaseController;
use Webmozart\Assert\Assert;

class LoginController extends XotBaseController
{
    /**
     * Login api.
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Assert::notNull($user = Auth::user(), '['.__LINE__.']['.class_basename($this).']');

            Assert::isInstanceOf($user, UserContract::class, '['.__LINE__.']['.class_basename($this).']');

            $success = [];
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse('User login successfully.', $success);
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }
}
