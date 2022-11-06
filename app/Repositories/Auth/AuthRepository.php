<?php

namespace App\Repositories\Auth;

use App\Models\Runner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{

    /**
     * Login
     * @param array $cred
     */
    public function login(array $cred)
    {
        if (Auth::attempt($cred)) {
            $user = Auth::user();
            $user->token = $this->generateToken($user);
            return $user;
        } else {
            return false;
        }
    }


    /**
     * Register
     * @param array $inputs
     */
    public function register(array $inputs)
    {
        $user = DB::transaction(function () use ($inputs) {
            $user = $this->prepareUser($inputs);
            $user->role = isset($inputs['role']) && $inputs['role'] == "runner" ? "runner" : "user";

            $user->saveOrFail();

            //user role as ruuner
            $runner = null;
            if (isset($inputs['role']) && $inputs['role'] == 'runner') {
                $runner = $this->prepareRunner($user, $inputs);
                $runner->saveOrFail();
            }

            $user->token = $this->generateToken($user);
            return $user;
        });

        return $user;
    }

    public function generateToken(User $user)
    {
        return $user->createToken('api')->plainTextToken;
    }

    public function prepareRunner($user, $inputs)
    {
        $runner = new Runner();
        $runner->cost_per_hour = $inputs['cost_per_hour'];
        $runner->user_id = $user->id;
        $runner->category_id = $inputs['category_id'];

        return $runner;
    }

    public function prepareUser($inputs)
    {
        $user = new User();
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = Hash::make($inputs['password']);
        $user->birthday = Carbon::parse($inputs['birthday'])->format('Y-m-d');
        $user->gender = $inputs['gender'];

        return $user;
    }
}
