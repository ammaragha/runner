<?php

namespace App\Helpers;

use Twilio\Rest\Client;

trait TwilioTrait
{

    /**
     * send OTP
     */
    public function sendOTP(string $email, string $phone)
    {
        $checkPhone = $this->getPhoneByEmail($email);
        if ($checkPhone == $phone) {
            $this->twilioService()->verifications
                ->create($phone, "sms");
            return true;
        } else {
            return false;
        }
    }


    /**
     * verify
     */
    public function verifyOTP(string $phone, string $code)
    {
        $verification = $this->twilioService()
            ->verificationChecks
            ->create(['to' => $phone, 'code' => $code]);

        return $verification->status;
    }




    //-------------------------------------------------------------------------------------------
    //Twilio
    private function twilio()
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        return  new Client($twilio_sid, $token);
    }

    private function twilioService()
    {
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        return $this->twilio()->verify->v2->services($twilio_verify_sid);
    }
}
