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
    public function prepareRunner(User $user, array $inputs);
}
