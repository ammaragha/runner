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
        $logged = $this->authRepo->login($request->only(['email', 'password']));

        if (!$logged)
            return $this->badRequest("email or password incorrect!");
        else if ($logged == 'notVerified')
            return $this->badRequest("phone not verified need to verfiy your phone");
        else if ($logged)
            return $this->succWithData(new AuthResource($logged), 'logged in successfully');
    }

    public function register(RegisterRequest $request)
    {
        $registed  = $this->authRepo->register($request->all());
        if ($registed) {
            $phone = $registed->phones()->where('default', true)->first()->phone;
            return $this->succMsg("user registed successfully, need to verify {$phone}");
        } else
            return $this->serverErr("something went wrong");
    }

    public function reset(ResetPasswordRequest $request){
        $password = $request->input('password');
        $phone = $request->input('phone');

        $resetPassword = $this->authRepo->reset($phone,$password);

        if ($resetPassword)
            return $this->succMsg('Password reseted');
        else {
            return $this->badRequest('Something went wrong, mabye i didnt found your phone');
        }
    }

    public function getPhoneByEmail(EmailRequest $request)
    {
        $phone = $this->authRepo->getPhoneByEmail($request->input('email'));
        if ($phone)
            return $this->succWithData(['phone' => $phone], 'Phone number need to verify');
        else {
            return $this->badRequest('Something went wrong, mabye i didnt found your phone');
        }
    }

    public function sendOTP(SendOTPRequest $request){
        $phone = $request->input('phone');

        $sendOTP = $this->authRepo->sendOTP($phone);
        if ($sendOTP)
            return $this->succWithData(['phone' => $phone], 'OTP sent successfully');
        else {
            return $this->badRequest('Something went wrong');
        }
    }

    
    public function verifyOTP(VerifyRequest $request){
        $code = $request->input('code');
        $phone = $request->input('phone');

        $verifyOTP = $this->authRepo->verifyOTP($phone,$code);
        if ($verifyOTP == 'approved')
            return $this->succWithData(['phone' => $phone], 'OTP verified successfully');
        else {
            return $this->badRequest('Something went wrong');
        }
    }


    public function verify(VerifyRequest $request){
        $phone = $request->input('phone');
        $code = $request->input('code');

        $verify = $this->authRepo->verify($phone,$code);
        if ($verify)
            return $this->succMsg('Phone number successfully verified, tou can login now');
        else {
            return $this->badRequest('Something went wrong');
        }
    }
}
