<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegister;
use App\Http\Requests\Auth\InitRegister;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterationController extends Controller
{
    /**
     * Get email and send email verification
     *
     * @param Register $request
     * @return UserResource
     */
    public function init(InitRegister $request)
    {
        $user = User::create(['email' => $request->email]);

        event(new Registered($user));

        return new UserResource($user);
    }

    /**
     * Undocumented function
     *
     * @param Register $request
     * @return void
     */
    public function complete(CompleteRegister $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        return new UserResource($user);
    }
}
