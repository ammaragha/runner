<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailRequest;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendOTPRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Resources\Auth\AuthResource;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private AuthRepositoryInterface $authRepo
    ) {
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authRepo->login($request->only(['email', 'password']));
            return $this->success('logged in successfully', new AuthResource($user));
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $registed  = $this->authRepo->register($request->all());
            $phone = $registed->phone;
            return $this->createdSuccessfully("user registed successfully, need to verify {$phone}", ['phone' => $phone]);
        } catch (\Exception $e) {
            return $this->serverErr("something went wrong: {$e->getMessage()}");
        }
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $password = $request->input('password');
            $phone = $request->input('phone');
            $resetPassword = $this->authRepo->reset($phone, $password);
            return $this->bool($resetPassword, 'password changed', 'password not changed');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }

    public function getPhoneByEmail(EmailRequest $request)
    {
        try {
            $phone = $this->authRepo->getPhoneByEmail($request->input('email'));
            return $this->success("your phone is {$phone}", ['phone' => $phone]);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }

    public function sendOTP(SendOTPRequest $request)
    {
        try {
            $phone = $request->input('phone');
            $sendOTP = $this->authRepo->sendOTP($phone);
            return $this->bool($sendOTP, 'OTP sent successfully', 'OTP not sent');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }


    public function verifyOTP(VerifyRequest $request)
    {
        try {
            $code = $request->input('code');
            $phone = $request->input('phone');

            $verifyOTP = $this->authRepo->verifyOTP($phone, $code);
            return $this->bool($verifyOTP,'OTP verified successfully','OTP not verfied!');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(),$e->getCode());
        }

        if ($verifyOTP)
            return $this->succWithData(['phone' => $phone], );
        else {
            return $this->badRequest('Something went wrong');
        }
    }


    public function verify(VerifyRequest $request)
    {
        try {
            $phone = $request->input('phone');
            $code = $request->input('code');
            $verified = $this->authRepo->verify($phone, $code);
            return $this->bool($verified, 'Phone verified', 'Phone not verfied');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}
