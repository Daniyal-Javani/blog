<?php

namespace App\Services;

use App\Models\User;

class ValidateOtpService
{
    public function execute(User $user, $code)
    {
        return $user->otps()->where('code', $code)->exists();
    }
}
