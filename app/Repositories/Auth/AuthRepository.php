<?php

namespace App\Repositories\Auth;

use App\Helpers\TwilioTrait;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
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
    public function login(array $cred): User
    {
        if (Auth::attempt($cred)) {
            $user = Auth::user();

            // get his defualt phone
            $hasVerifiedphone = $user->phone_verified_at;
            if (!$hasVerifiedphone) {
                Auth::logout();
                throw new Exception("phone not verified", Response::HTTP_BAD_REQUEST);
            } else {
                $user->token = $this->generateToken($user);
                return $user;
            }
        } else {
            throw new Exception("email or password incorrect!", Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Register
     * @param array $inputs
     */
    public function register(array $inputs): User
    {
        $user = DB::transaction(function () use ($inputs) {
            $user = $this->prepareUser($inputs);
            $user['role'] = isset($inputs['role']) && $inputs['role'] == "runner" ? "runner" : "user";
            $user = User::create($user);

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
    public function reset(string $phone,  string $password): bool
    {
        $user = User::where('phone', $phone)->first();

        if (!$user)
            throw new Exception('Phone not exist', Response::HTTP_BAD_REQUEST);
        $updated = $user->update([
            'password' => Hash::make($password)
        ]);

        return $updated;
    }

    /**
     * generate Token for authed user
     */
    public function generateToken(User $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }


    /**
     * prepare Runner data
     */
    public function prepareRunner($inputs): array
    {
        $runner = [
            'cost_per_hour' => $inputs['cost_per_hour'],
            'service_id' => $inputs['service_id']
        ];

        return $runner;
    }

    /**
     * prepare user data
     */
    public function prepareUser($inputs): array
    {
        $user = [
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
            'birthday' => Carbon::parse($inputs['birthday'])->format('Y-m-d'),
            'gender' => $inputs['gender'],
            'phone' => $inputs['phone']
        ];

        return $user;
    }


    /**
     * prepare address data
     */
    public function prepareAddress(array $inputs): array
    {
        $address = [
            'name' => isset($inputs['addressName']) ? $inputs['addressName'] : 'home',
            'phone' => $inputs['phone'],
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
    public function getPhoneByEmail(string $email): string
    {
        $user = User::where('email', $email)->first();
        return $user->phone;
    }

    /**
     * verify phone number
     */
    public function verify(string $phone, string $code): bool
    {
        $isExist = User::where('phone', $phone)->first();
        if (!$isExist)
            throw new Exception("phone not Exist", Response::HTTP_BAD_REQUEST);
        if ($isExist && $isExist->phone_verified_at)
            throw new Exception("this phone number is verified, you can login now", Response::HTTP_BAD_REQUEST);

        $verifyOTP = $this->verifyOTP($phone, $code);
        if ($verifyOTP) {
            $updated = User::where('phone', $phone)->update(['phone_verified_at' => Carbon::now()]);
            return $updated;
        } else {
            return false;
        }
    }
}
