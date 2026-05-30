<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $mobile, string $message): bool
    {
        /*
         اینجا بعداً API پنل پیامکی را وصل کن.
         مثال:
         Http::post('https://sms-provider.ir/api/send', [
             'api_key' => config('services.sms.key'),
             'mobile' => $mobile,
             'message' => $message,
         ]);
        */

        Log::info('SMS SENT', [
            'mobile' => $mobile,
            'message' => $message,
        ]);

        return true;
    }
}