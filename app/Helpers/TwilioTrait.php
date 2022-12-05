<?php

namespace App\Helpers;

use Twilio\Rest\Client;

trait TwilioTrait
{

    /**
     * send OTP
     */
    public function sendOTP(string $phone): bool
    {
        try {
            $sent =  $this->twilioService()->verifications
                ->create($phone, "sms");
            if ($sent) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $e = $this->twilioErrors($e);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function sendOTPMsg(string $phone,string $msg): bool
    {
        try {
            $msgService = getenv('TWILIO_MASSEGES_SID');
            $options = [
                "messagingServiceSid" => $msgService,
                "body" => $msg
            ];
            $sent = $this->twilio()->messages->create($phone, $options);
            dd($sent->status);
            if ($sent) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $e = $this->twilioErrors($e);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    /**
     * verify
     */
    public function verifyOTP(string $phone, string $code): bool
    {
        try {
            $verification = $this->twilioService()
                ->verificationChecks
                ->create(['to' => $phone, 'code' => $code]);
            if ($verification->status == 'approved') {
                return true;
            } elseif ($verification->status == 'pending') {
                throw new \Exception("code not correct", 400);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $e = $this->twilioErrors($e);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
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



    private function twilioErrors(\Exception $e)
    {
        $status = $e->getCode();
        $msg = $e->getMessage();
        switch ($e->getCode()) {
            case 60202:
                $status = 429;
                $msg = explode(":", $e->getMessage())[0];
                break;
            case 20404:
                $status = 404;
                $msg = "Code not correct try again " . explode(":", $e->getMessage())[0];
                break;
            case 20003:
                $status = 401;
                break;
            case 20008:
                $status = 403;
                break;
            case 550 < $e->getCode():
                $status = 500;
                break;
            default:
                break;
        }
        return new \Exception($msg, $status);
    }
}
