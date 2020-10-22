<?php

namespace App\Services;

use App\Models\User;
use Str;

class CreateOtpService
{
    public function execute(User $user)
    {
        // TODO: disable previous codes of the user
        // TODO: add expire time
        // TODO: disable code after use
        $code = Str::random(5);

        $user->otps()->create([
            'code' => $code,
        ]);

        return $code;
    }
}
