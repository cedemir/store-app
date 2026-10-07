<?php

namespace App\Services\Payments;

class PayHappyService implements PaymentInterface
{
    public function doPayment(array $data): array
    {
        //payment Algorithm
        return ['gateway_code' => str()->uuid()];
    }
}
