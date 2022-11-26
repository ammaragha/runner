<?php

namespace App\Repositories\Auth;

use App\Helpers\TwilioTrait;
use App\Models\Phone;
use App\Models\Runner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface, OTPInterface
{
    use TwilioTrait;
    /**
     * Login
     * @param array $cred
     */
    public function login(array $cred)
    {
        if (Auth::attempt($cred)) {
            $user = Auth::user();

            // get his defualt phone
            $hasVerifiedphone = $user->phones()->where('default', true)->where('isVerified', true)->first();

            if (!$hasVerifiedphone) {
                Auth::logout();
                return "notVerified";
            } else {
                $user->token = $this->generateToken($user);
                return $user;
            }
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

            //phone
            $user->phones()->create(['phone' => $inputs['phone'], 'default' => true]);

            //address
            $address = $this->prepareAddress($inputs);
            $user->addresses()->create($address);

            //user role as ruuner
            $runner = null;
            if (isset($inputs['role']) && $inputs['role'] == 'runner') {
                $runner = $this->prepareRunner($inputs);
                $user->runner()->create($runner);
            }

            return $user;
        });

        return $user;
    }

    /**
     * reset password
     */
    public function reset(string $phone,  string $password)
    {
        $user = Phone::where('phone', $phone)->first()->user();
        $updated = $user->update([
            'password' => Hash::make($password)
        ]);

        return $updated;
    }

    /**
     * generate Token for authed user
     */
    public function generateToken(User $user)
    {
        return $user->createToken('api')->plainTextToken;
    }


    /**
     * prepare Runner data
     */
    public function prepareRunner($inputs)
    {
        $runner = [
            'cost_per_hour' => $inputs['cost_per_hour'],
            'category_id' => $inputs['category_id']
        ];

        return $runner;
    }

    /**
     * prepare user data
     */
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


    /**
     * prepare address data
     */
    public function prepareAddress(array $inputs)
    {
        $address = [
            'name' => $inputs['addressName'],
            'city' => $inputs['city'],
            'state' => $inputs['state'],
            'lat' => isset($inputs['lat']) ? $inputs['lat'] : null,
            'long' => isset($inputs['long']) ? $inputs['long'] : null,
            'street' => isset($inputs['street']) ? $inputs['street'] : null,
            'suite' => isset($inputs['suite']) ? $inputs['suite'] : null,
            'zip' => isset($inputs['zip']) ? $inputs['zip'] : null,
        ];

        return $address;
    }

    /**
     * get Phone from Email
     */
    public function getPhoneByEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        $phone = $user->phones()->where('default', true)->first();
        if ($phone)
            return $phone->phone;
        else
            return false;
    }

    /**
     * verify phone number
     */
    public function verify(string $phone, string $code)
    {
        $verifyOTP = $this->verifyOTP($phone, $code);
        if ($verifyOTP == 'approved') {
            $updated = Phone::where('phone', $phone)->update(['isVerified' => true]);
            return $updated;
        } else {
            return false;
        }
    }
}
