<?php

/**
 * --.
 */

declare(strict_types=1);

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Xot\Datas\XotData;

class UpgradeController extends Controller
{
    public function __invoke(Request $_request): void
    {
        $user_class = XotData::make()->getUserClass();
        $users = $user_class::get();
        /* da id a uuid
         * foreach ($users as $user) {
         * if (strlen(is_string($user) ? $user : (string) $user->) >= 32) { // gia' convertito
         * continue;
         * }
         * $old_id = $user->;
         * $new_id = Str::uuid();
         * $where = ['user_id' => $old_id];
         * $morph = ['model_type' => 'user', 'model_id' => $old_id];
         * $rows = ModelHasRole::where($morph)->update(['model_id' => $new_id]);
         * $rows = TeamUser::where($where)->update(['user_id' => $new_id]);
         * $user-> = $new_id;
         * $user->save();
         * echo '<br> from :'.$old_id.' => '.$new_id;
         * }
         */
        echo '<hr/>+Done';
    }
}

/*
 * from :10 => 95cda850-dd86-4de3-86bc-6caf0ee18293
 * from :11 => d60cbf20-5c99-45b7-8161-223a19a92061
 * from :2 => fa42b970-7e7b-4cce-a864-5a1f3410eaa0
 * from :3 => 103d6927-b69c-4772-9dff-71052e5e8356
 * from :4 => ced23ec3-29d4-43e0-a6a9-12818e840ce3
 * from :5 => 87dc2759-3c82-4812-ad83-28fc28ff6de9
 * from :6 => 06e81925-b15f-4d02-bb91-aa3a83021f57
 * from :7 => 67daea8d-3cf3-4d90-b624-cd6f9d7d2a53
 * from :8 => 9557792a-b319-4058-93b8-75f1f6a34379
 * from :9 => 1e19e82a-e8d9-450c-a879-9933644573dc
 *
 */
