<?php

namespace App\Services;

use App\Models\User;
use Str;

class CreateOtpService
{
    public function execute(User $user)
    {
        $code = Str::random(5);

        $user->otps()->create([
            'code' => $code,
        ]);

        return $code;
    }
}
