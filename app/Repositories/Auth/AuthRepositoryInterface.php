<?php

namespace App\Repositories\Auth;

use App\Models\User;

interface AuthRepositoryInterface 
{
    /**
     * make a Login
     * @param array $cred
     */
    public function login(array $cred);

    /**
     * make a registration
     * @param array $inputs
     */
    public function register(array $inputs);

    /**
     * reset password
     */
    public function reset(string $phone,string $password);

    /**
     * create Token
     * 
     */
    public function generateToken(User $user);

    /**
     * prapare user data to save it
     */
    public function prepareUser(array $inputs);

    /**
     * if user is runner prepare 
     * 
     */
    public function prepareRunner(array $inputs);

    /**
     * prepare address data for user
     */
    public function prepareAddress(array $inputs);

    /**
     * get phone from email
     */
    public function getPhoneByEmail(string $email);

    /**
     * verify
     */
    public function verify(string $phone,string $code);

}
