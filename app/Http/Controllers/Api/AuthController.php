<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
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
        $logged = $this->authRepo->login($request->only(['email','password']));
        if ($logged)
            return $this->succWithData(new AuthResource($logged), 'logged in successfully');
        else
            return $this->badRequest("email or password incorrect!");
    }

    public function register(RegisterRequest $request)
    {
        $registed  = $this->authRepo->register($request->all());
        if ($registed)
            return $this->succWithData(new AuthResource($registed), 'new user registed');
        else
            return $this->serverErr("something went wrong");
    }
}
