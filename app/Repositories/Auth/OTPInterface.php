<?php

namespace App\Repositories\Auth;

interface OTPInterface
{
    public function sendOTP(string $email, string $phone);
    public function verifyOTP(string $phone, string $code);
}
