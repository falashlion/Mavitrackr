<?php

namespace App\Http\Controllers;

use App\Http\Requests\passwordResetRequest;
use App\Http\Requests\passwordSetRequest;
use App\Repositories\PasswordResetRepository;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ForgotPasswordController extends Controller
{


    protected $PasswordResetRepository;

    public function __construct(PasswordResetRepository $PasswordResetRepository)
    {
        $this->PasswordResetRepository = $PasswordResetRepository;
    }
    /**
     * forgotPassword
     *
     * @param  passwordResetRequest $request Contains the email for the password reset.
     * @return Response Returns the success status with a message or the error status with an error.
     */
    public function forgotPassword(passwordResetRequest $request)
    {
    $status = Password::sendResetLink($request->all());
    if ($status === Password::RESET_LINK_SENT) {
        return ResponseBuilder::asSuccess()
        ->withMessage('Reset link sent to your email.')
            ->withHttpCode(200)
            ->build();
    } else {
        return ResponseBuilder::asError($status)
            ->withMessage('Unable to send reset link')
            ->withHttpCode(400)
            ->build();
    }

    }

    /**
     * resetPassword
     *
     * @param  passwordSetRequest $request contains the reseted password to be update din the database
     * @return Response  Returns the status success with a message or the status error message.
     */
    public function resetPassword(passwordSetRequest $request)
    {
        $status = Password::reset($request->all(),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            event(new PasswordReset($user));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return ResponseBuilder::asSuccess()
                ->withMessage('Password reset successfully')
                ->withHttpCode(201)
                ->build();
        } else {
            return ResponseBuilder::asError($status)
                ->withMessage('Unable to reset password')
                ->withHttpCode(400)
                ->build();
        }
    }

}
