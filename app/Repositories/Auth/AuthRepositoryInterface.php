<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface AuthRepositoryInterface
{
    /**
     * make a Login
     * @param array $cred
     */
    public function login(array $cred): Model;

    /**
     * make a registration
     * @param array $inputs
     */
    public function register(array $inputs): Model;

    /**
     * reset password
     */
    public function reset(string $phone, string $password): bool;

    /**
     * create Token
     * 
     */
    public function generateToken(User $user): string;

    /**
     * prapare user data to save it
     */
    public function prepareUser(array $inputs): array;

    /**
     * if user is runner prepare 
     * 
     */
    public function prepareRunner(array $inputs):array;

    /**
     * prepare address data for user
     */
    public function prepareAddress(array $inputs):array;

    /**
     * get phone from email
     */
    public function getPhoneByEmail(string $email):string;

    /**
     * verify
     */
    public function verify(string $phone, string $code):bool;
}
