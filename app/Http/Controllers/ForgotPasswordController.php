<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SendForgotPasswordRequest;
use App\Mail\SendEmailVerificationMail;
use App\Models\User;
use App\Services\CreateOtpService;
use App\Services\ValidateOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    protected $createOtpService;
    protected $validateOtpService;

    public function __construct(
        CreateOtpService $createOtpService,
        ValidateOtpService $validateOtpService
    ) {
        $this->createOtpService = $createOtpService;
        $this->validateOtpService = $validateOtpService;
    }

    public function sendOtp(SendForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $code = $this->createOtpService->execute($user);

        Mail::to($user)->send(new SendEmailVerificationMail($code));

        return response()->json([
            'message' => 'Verification mail sent successfully',
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $email = $request->email;
        $code = $request->code;
        $password = $request->password;
        $user = User::where('email', $email)->first();

        if (! $this->validateOtpService->execute($user, $code)) {
            throw ValidationException::withMessages([
                'code' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->update([
            'password' => bcrypt($password),
        ]);

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }
}
