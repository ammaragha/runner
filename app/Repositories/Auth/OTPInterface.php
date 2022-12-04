<?php

namespace App\Repositories\Auth;

interface OTPInterface
{
    public function sendOTP(string $phone):bool;
    public function verifyOTP(string $phone, string $code):bool;
}
