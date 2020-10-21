<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Models\User;
use App\Services\ValidateOtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    protected $validateOtpService;

    public function __construct(ValidateOtpService $validateOtpService)
    {
        $this->validateOtpService = $validateOtpService;
    }

    public function __invoke(VerifyEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $code = $request->code;

        if (! $user || ! $this->validateOtpService->execute($user, $code)) {
            throw ValidationException::withMessages([
                'code' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->update([
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'message' => 'Your account is successfully verified',
            'token' => $user->createToken('Postman')->plainTextToken,
        ]);
    }
}
